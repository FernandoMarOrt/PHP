<?php



if(isset($_POST["btnBorrar"]))
{
    unset($_POST);
}



if(isset($_POST["btnEnviar"]))
{
    //compruebo los errores
    $error_captcha=false;
    $error_nombre=$_POST["nombre"]=="";
    $error_usuario=$_POST["usuario"]=="";
    if(!$error_usuario)
    {

        $respuesta=consumir_servicios_REST(DIR_SERV."/repetido_insert/usuarios/usuario/".$_POST["usuario"],"GET");
        $json=json_decode($respuesta,true);
        if(!$json)
        {
            session_destroy();
            die(error_page("Práctica Rec 3","<h1>Práctica Rec 3</h1><p>Sin respuesta oportuna de la API</p>"));  
        }

        if(isset($json["error_bd"]))
        {
            session_destroy();
            consumir_servicios_REST(DIR_SERV."/salir","POST",$datos_env);
            die(error_page("Práctica Rec 3","<h1>Práctica Rec 3</h1><p>".$json["error_bd"]."</p>"));
        }
        $error_usuario=$json["repetido"];



    }
    $error_clave=$_POST["clave"]=="";
    $error_dni=$_POST["dni"]=="" || !dni_bien_escrito($_POST["dni"]) || !dni_valido($_POST["dni"]);
    if(!$error_dni)
    {
        $respuesta=consumir_servicios_REST(DIR_SERV."/repetido_insert/usuarios/dni/".strtoupper($_POST["dni"]),"GET");
        $json=json_decode($respuesta,true);
        if(!$json)
        {
            session_destroy();
            die(error_page("Práctica Rec 3","<h1>Práctica Rec 3</h1><p>Sin respuesta oportuna de la API</p>"));  
        }

        if(isset($json["error_bd"]))
        {
            session_destroy();
            consumir_servicios_REST(DIR_SERV."/salir","POST",$datos_env);
            die(error_page("Práctica Rec 3","<h1>Práctica Rec 3</h1><p>".$json["error_bd"]."</p>"));
        }
        $error_dni=$json["repetido"];
    }
 
    $error_foto=$_FILES["foto"]["name"]!="" && ($_FILES["foto"]["error"] || !explode(".", $_FILES["foto"]["name"])|| !getimagesize($_FILES["foto"]["tmp_name"] ) || $_FILES["foto"]["size"]>500*1024);//Foto no obligatoria
    //$error_foto=$_FILES["foto"]["name"]=="" || $_FILES["foto"]["error"] || !explode(".", $_FILES["foto"]["name"])|| !getimagesize($_FILES["foto"]["tmp_name"] ) || $_FILES["foto"]["size"]>500*1024;//Foto obligatoria
    $error_form=$error_nombre|| $error_usuario || $error_clave || $error_dni || $error_foto;
   
    if(!$error_form)
    {
        //Compruebo que no es un robot quien ha rellenado el formulario
        $datos_env["secret"]=RECAPTCHA_V3_SECRET_KEY;
        $datos_env["response"]=$_POST['token'];
        $respuesta=consumir_servicios_REST("https://www.google.com/recaptcha/api/siteverify","POST",$datos_env);
        $arrRespuesta = json_decode($respuesta, true);
        if(!$arrRespuesta)
        {
            session_destroy();
            die(error_page("Práctica Rec 3","<h1>Práctica Rec 3</h1><p>El servicio recaptcha de Google no disponible en estos momentos. Pruebe a registrarse más tarde.</p>"));
        }

        // verificar la respuesta
        $error_captcha=!($arrRespuesta["success"] == '1' && $arrRespuesta["action"] == $_POST['action'] && $arrRespuesta["score"] >= 0.5);
        
        if(!$error_captcha)
        {

            $datos_env_insert["usuario"]=$_POST["usuario"];
            $datos_env_insert["nombre"]=$_POST["nombre"];
            $datos_env_insert["clave"]=md5($_POST["clave"]);
            $datos_env_insert["dni"]=strtoupper($_POST["dni"]);
            $datos_env_insert["sexo"]=$_POST["sexo"];
            if(isset($_POST["subscripcion"]))
                $datos_env_insert["subscripcion"]=1;
            else
                $datos_env_insert["subscripcion"]=0;

            
            $respuesta=consumir_servicios_REST(DIR_SERV."/insertar_usuario","POST",$datos_env_insert);
            $json=json_decode($respuesta,true);
            if(!$json)
            {
                session_destroy();
                die(error_page("Práctica Rec 3","<h1>Práctica Rec 3</h1><p>Sin respuesta oportuna de la API</p>"));  
            }
        
            if(isset($json["error_bd"]))
            {
                session_destroy();
                consumir_servicios_REST(DIR_SERV."/salir","POST",$datos_env);
                die(error_page("Práctica Rec 3","<h1>Práctica Rec 3</h1><p>".$json["error_bd"]."</p>"));
            }

            $mensaje="Se ha registrado con éxito";
    
            if($_FILES["foto"]["name"]!="")
            {
                $ultm_id=$json["ultm_id"];
                $array_ext=explode(".", $_FILES["foto"]["name"]);
                $ext=".".end($array_ext);
                $nombre_nuevo="img_".$ultm_id.$ext;
                @$var=move_uploaded_file($_FILES["foto"]["tmp_name"],"images/".$nombre_nuevo);
                if($var)
                {

                    $datos_env_act["nombre_foto"]=$nombre_nuevo;
                    $datos_env_act["id_usuario"]=$ultm_id;
                    $respuesta=consumir_servicios_REST(DIR_SERV."/actualizar_foto","PUT",$datos_env_act);
                    $json=json_decode($respuesta,true);
                    if(!$json)
                    {
                        session_destroy();
                        die(error_page("Práctica Rec 3","<h1>Práctica Rec 3</h1><p>Sin respuesta oportuna de la API</p>"));  
                    }
                
                    if(isset($json["error_bd"]))
                    {
                        if(file_exists("images/".$nombre_nuevo))
                            unlink("images/".$nombre_nuevo);
                        
                        $mensaje="Usuario insertado con éxito pero con la imagen por defecto por un problema en la BD del servidor";
                    }

                }
                else
                {
                    $mensaje="Se ha registrado con éxito pero con la imagen por defecto ya que no se ha podido mover la imagen a la carpeta destino en el servidor";
                }
              
            }
    
            // Dos opciones:
            // Sin loguearse o logueando

            //Logueando al usuario recién registrado
            
            $datos_env["usuario"]=$_POST["usuario"];
            $datos_env["clave"]=md5($_POST["clave"]);
            $respuesta=consumir_servicios_REST(DIR_SERV."/login","POST",$datos_env);
            $json=json_decode($respuesta,true);
            if(!$json)
            {
                session_destroy();
                die(error_page("Práctica Rec 3","<h1>Práctica Rec 3</h1><p>Sin respuesta oportuna de la API</p>"));  
            }
            if(isset($json["error_bd"]))
            {
                session_destroy();
                die(error_page("Práctica Rec 3","<h1>Práctica Rec 3</h1><p>".$json["error_bd"]."</p>"));
            }

            if(isset($json["usuario"]))
            {
                $_SESSION["usuario"]=$json["usuario"]["usuario"];
                $_SESSION["clave"]=$json["usuario"]["clave"];
                $_SESSION["ultm_accion"]=time();
                $_SESSION["api_key"]=$json["api_key"];
                
                $_SESSION["mensaje_registro"]=$mensaje;
            }
            else
            {
                $_SESSION["seguridad"]=$mensaje;
            }
            header("Location:index.php");
            exit();



            //Sin loguear al usuario recién registrado
            //$_SESSION["seguridad"]=$mensaje;
            //header("Location:index.php");
            //exit();
        }
        
    }


}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica Rec 3</title>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8=" crossorigin="anonymous"></script>
 
	<!-- Cambia 6Lc9nL8pAAAAAHj8FwPy0B9c03b9tgdxAM4X-5Me por tu clave de sitio web -->
    <script src="https://www.google.com/recaptcha/api.js?render=6LeclMUpAAAAAPfmd9Phvk7tVUJtev9C6UY7CMH_"></script>
    <style>
        .error{color:red}
    </style>
</head>
<body>
<h1>Práctica Rec 3</h1>
    <form id="form" action="index.php" method="post" enctype="multipart/form-data">
        <p>
            <label for="usuario">Usuario: </label><br>
            <input type="text" id="usuario" name="usuario" value="<?php if(isset($_POST["usuario"])) echo $_POST["usuario"];?>" placeholder="Usuario...">
            <?php
            if(isset($_POST["btnEnviar"])&& $error_usuario)
            {
                if($_POST["usuario"]=="")
                    echo "<span class='error'> Campo vacío</span>";
                else
                    echo "<span class='error'> Usuario repetido</span>";
            }
                
            ?>
        </p>
        <p>
            <label for="nombre">Nombre: </label><br>
            <input type="text" id="nombre" name="nombre" value="<?php if(isset($_POST["nombre"])) echo $_POST["nombre"];?>" placeholder="Nombre...">
            <?php
            if(isset($_POST["btnEnviar"])&& $error_nombre)
                echo "<span class='error'> Campo vacío</span>";
            ?>
        </p>
        <p>
            <label for="clave">Contraseña: </label><br>
            <input type="password" id="clave" name="clave" placeholder="Contraseña...">
            <?php
            if(isset($_POST["btnEnviar"])&& $error_clave)
                echo "<span class='error'> Campo vacío</span>";
            ?>
        </p>
        <p>
            <label for="dni">DNI: </label><br>
            <input type="text" id="dni" name="dni" value="<?php if(isset($_POST["dni"])) echo $_POST["dni"];?>" placeholder="DNI: 11223344Z">
            <?php
            if(isset($_POST["btnEnviar"])&& $error_dni)
            {
                if($_POST["dni"]=="")
                    echo "<span class='error'> Campo vacío</span>";
                else if(!dni_bien_escrito($_POST["dni"]))
                    echo "<span class='error'> DNI no está bien escrito</span>";
                else if(!dni_valido($_POST["dni"]))
                    echo "<span class='error'> DNI no es válido</span>";
                else
                    echo "<span class='error'> DNI repetido</span>";
            }
            ?>
        </p>
        <p>
            <label>Sexo: </label><br>
            <input type="radio" id="hombre" name="sexo" value="hombre" <?php if(!isset($_POST["sexo"]) || (isset($_POST["sexo"]) && $_POST["sexo"]=="hombre")) echo "checked";?>>
            <label for="hombre">Hombre: </label><br>
            <input type="radio" id="mujer" name="sexo" value="mujer" <?php if(isset($_POST["sexo"]) && $_POST["sexo"]=="mujer") echo "checked";?>>
            <label for="mujer">Mujer: </label><br>
        </p>
        <p>
            <label for="foto">Incluir mi foto (Máx. 500 KB)</label>
            <input type="file" name="foto" id="foto" accept="image/*">
            <?php
            if(isset($_POST["btnEnviar"])&& $error_foto)
            {
                if($_FILES["foto"]["error"])
                    echo "<span class='error'> Error en la subida del fichero al servidor </span>";
                else if (!explode(".",$_FILES["foto"]["name"]))
                    echo "<span class='error'> El fichero subido debe tener extensión </span>";
                else if (! getimagesize($_FILES["foto"]["tmp_name"]))
                    echo "<span class='error'> El fichero subido debe ser una imagen</span>";
                else
                    echo "<span class='error'> El tamaño del fichero no debe superar los 500 KB</span>";
            }
            ?>
        </p>
        <p>
            <input type="checkbox" id="subsc" name="subscripcion" <?php if(isset($_POST["subscripcion"])) echo "checked";?>>
            <label for="subsc">Suscribirme al boletín de novedades: </label><br>
        </p>
        <p>
            
            <button type="submit" data-destino="enviar" name="btnEnviar">Guardar Cambios</button>
            <button type="submit" data-destino="borrar" name="btnBorrar">Borrar los datos introducidos</button>
        </p>

        <?php 
            if(isset($_POST["btnEnviar"]) && $error_captcha)
                echo "<p><span class='error'> Según Google Recaptcha, el registo lo está haciendo un robots. Por favor, vuelva a intentarlo.</span></p>";
        ?>
    </form>
    <script>
        //Cómo tengo dos botones que hacen submit tengo que ver cual de ellos es el que lo provoca ya que sólo uno de ellos necesita recaptcha (enviar)
        var button_enviar;
        $("button").click(function(){
            button_enviar=$(this).data('destino') == 'enviar';
        })
        $('#form').submit(function(event) {
            if(button_enviar)
            {
                event.preventDefault();
                /*Cambia 6Lc9nL8pAAAAAHj8FwPy0B9c03b9tgdxAM4X-5Me por tu clave de sitio web*/
                grecaptcha.ready(function() {
                    grecaptcha.execute('6LeclMUpAAAAAPfmd9Phvk7tVUJtev9C6UY7CMH_', {action: 'registro'}).then(function(token) {
                        $('#form').prepend('<input type="hidden" name="token" value="' + token + '">');
                        $('#form').prepend('<input type="hidden" name="action" value="registro">');
                        $('#form').prepend('<input type="hidden" name="btnEnviar">');//Al hacer el event.preventDefault() el $_POST[btnEnviar] se pierde
                        $('#form').unbind('submit').submit();
                    });
                });
            }
        });
  </script>
</body>
</html>