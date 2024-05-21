<?php
//No estoy logueado
    if(isset($_POST["btnEntrar"]))
    {
        if(!$error_form)
        {
    
            $url=DIR_SERV."/login";
            $datos["usuario"]=$_POST["usuario"];
            $datos["clave"]=md5($_POST["clave"]);
            $respuesta=consumir_servicios_REST($url,"POST",$datos);
            $obj=json_decode($respuesta);
            if(!$obj)
            {
                session_destroy();
                die(error_page("LIBRERIA","<h1>Libreria</h1><p>Error consumiendo el servicio: ".$url."</p>"));
            }
    
            if(isset($obj->error))
            {
                session_destroy();
                die(error_page("LIBRERIA","<h1>Libreria</h1><p>".$obj->error."</p>"));
            }
    
            if(isset($obj->mensaje))
            {
                $error_usuario=true;
            }
            else
            {
    
                $_SESSION["usuario"]=$obj->usuario->usuario;
                $_SESSION["clave"]=$obj->usuario->clave;
                $_SESSION["ult_accion"]=time();
                
                $_SESSION["api_session"]=$obj->api_session;
                
                if($obj->usuario->tipo=="admin")
                    header("Location:admin/index.php");
                else
                    header("Location:index.php");
                
                exit();
            }
    
        }

    }
    

?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Examen3 Curso 23-24</title>
        <style>
            img{height:200px}
            div.libros{text-align:center;width:30%;margin-top:2.5%;margin-left:2.5%;float:left}
            
        </style>
    </head>
    <body>
        <h1>Librería</h1>
        <form action="index.php" method="post">
            <p>
                <label for="usuario">Usuario:</label>
                <input type="text" name="usuario" id="usuario" value="<?php if(isset($_POST["usuario"])) echo $_POST["usuario"];?>">
                <?php
                if(isset($_POST["usuario"])&& $error_usuario)
                    if($_POST["usuario"]=="")
                        echo "<span class='error'> Campo vacío</span>"; 
                    else
                        echo "<span class='error'> Usuario/clave incorrectos</span>"; 
                ?>
            </p>
            <p>
                <label for="clave">Contraseña:</label>
                <input type="password" name="clave" id="clave">
                <?php
                if(isset($_POST["clave"])&& $error_clave)
                    echo "<span class='error'> Campo vacío</span>";    
                ?>
            </p>
            <p>
                <button type="submit" name="btnEntrar">Entrar</button>
            </p>
        </form>
        <?php
        if(isset($_SESSION["seguridad"]))
        {
            echo "<p class='mensaje'>".$_SESSION["seguridad"]."</p>";
            session_destroy();
        }


        require "vistas/vista_libros_atres.php";
        ?>
    </body>
    </html>
