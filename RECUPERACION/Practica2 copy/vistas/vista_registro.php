<?php



if (isset($_POST["btnReset"])) {

    unset($_POST); //SI ESTA CREADO EL $_POST LO DESTRUYE PARA QUE SE PUEDAN BORRAR LOS DATOS
}

if (isset($_POST["btnGuardar"])) {

    $error_usuario = $_POST["usuario"] == "";
    if (!$error_usuario) {

        try {
            $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        } catch (PDOException $e) {
            session_destroy();
            die(error_page("Practica Rec 2", "<h1>Practica Rec 2</h1><p>No he podido conectarse a la base de batos: " . $e->getMessage() . "</p>"));
        }

        $error_usuario = (repetido($conexion,"usuarios","usuario",$_POST["usuario"]));
        if (is_string($error_usuario)) {

            $conexion = null;
            session_destroy();
            die(error_page("Practica Rec 2", "<h1>Practica Rec 2</h1><p>" . $error_usuario . "</p>"));
        }
    }
    $error_nombre = $_POST["nombre"] == "";
    $error_password = $_POST["password"] == "";
    $error_dni = $_POST["dni"] == "" || !dni_bien_escrito(strtoupper($_POST["dni"])) || !dni_valido(strtoupper($_POST["dni"]));

    if (!$error_dni) {
        if (!isset($conexion)) {
            try {
                $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
            } catch (PDOException $e) {
                session_destroy();
                die(error_page("Practica Rec 2", "<h1>Practica Rec 2</h1><p>No he podido conectarse a la base de batos: " . $e->getMessage() . "</p>"));
            }
        }


        $error_dni = (repetido($conexion,"usuarios","usuario",strtoupper($_POST["dni"])));
        if (is_string($error_dni)) {

            $conexion = null;
            session_destroy();
            die(error_page("Practica Rec 2", "<h1>Practica Rec 2</h1><p>" . $error_dni . "</p>"));
        }
    }


    /*Foto no obligatoria*/
    $error_archivo = $_FILES["archivo"]["name"] != "" && ($_FILES["archivo"]["error"] || !explode(".", $_FILES["archivo"]["name"]) || !getimagesize($_FILES["archivo"]["tmp_name"]) || $_FILES["archivo"]["size"] > 500 * 1024);

    /*Foto obligatoria*
    $error_archivo = $_FILES["archivo"]["name"] == "" || ($_FILES["archivo"]["error"] || !explode(".", $_FILES["archivo"]["name"]) || !getimagesize($_FILES["archivo"]["tmp_name"]) || $_FILES["archivo"]["size"] > 500 * 1024);
    */
    $error_form = $error_usuario || $error_nombre || $error_password || $error_dni || $error_archivo;

    if (!$error_form) {


        try {
            if(isset($_POST["subscripcion"])){
                $subs=1;
            }else{
                $subs=0;
            }
            $consulta = "insert into usuarios (usuario,nombre,clave,dni,sexo,subscripcion) values (?,?,?,?,?,?)";
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute([$_POST["usuario"],$_POST["nombre"],md5($_POST["clave"]),strtoupper($_POST["dni"]),$_POST["sexo"],$subs]);
            $respuesta = $sentencia->rowCount() > 0;
            $sentencia=null;
        } catch (Exception $e) {
            $sentencia=null;
            $conexion=null;
            session_destroy();
            die(error_page("Practica Rec 2", "<h1>Practica Rec 2</h1><p>" . $e->getMessage(). "</p>"));
        }

        $mensaje="Se ha registrado con exito";
        if($_FILES["foto"]["name"]!=""){
            $ultimo_id=$conexion->lastInsertId();
            $array_ext=explode(".", $_FILES["archivo"]["name"]);
            $ext=".".end($array_ext);
            $nombre_nuevo="img_".$ultimo_id.$ext;
            @$var=move_uploaded_file($_FILES["foto"]["tmp_name"],"Img/".$nombre_nuevo);
            if($var){
                try {

                    $consulta = "update usuarios set foto=? where id_usuario=?";
                    $sentencia = $conexion->prepare($consulta);
                    $sentencia->execute([$nombre_nuevo, $ultimo_id]);
                    $sentencia=null;
                } catch (Exception $e) {
                    unlink("images/".$nombre_nuevo);
                    $sentencia=null;
                    $conexion=null;
                    session_destroy();
                    die(error_page("Practica Rec 2", "<h1>Practica Rec 2</h1><p>" . $e->getMessage(). "</p>"));
                }



            }else{
                $mensaje="Se ha registrado con exito pero con la imagen por defecto ya que no se ha podido mover la imagen a la carpeta destino en el servidor";
            }
        }


        $conexion = null;
        $_SESSION["mensaje_registro"] = $mensaje;
        $_SESSION["usuario"] = $_POST["usuario"];
        $_SESSION["clave"] = $_POST["clave"];
        $_SESSION["ultima_accion"] = time();
        header("Location:index.php");
        exit();
    }

    if(isset($conexion)){
        $conexion=null;
    }
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Practica01</title>
    <style>
        .error {
            color: red
        }
    </style>
</head>

<body>

    <h1>Practica Rec 2</h1>
    <form action="index.php" method="post" enctype="multipart/form-data">
        <p>
            <label>Usuario:</label><br>
            <input type="text" name="usuario" placeholder="usuario" id="usuario" value="<?php if (isset($_POST["usuario"])) echo $_POST["usuario"]; ?>">
            <?php
            if (isset($_POST["btnGuardar"]) && $error_form) {
                if ($_POST["usuario"] == "") {
                    echo "<span class='error'>*Debes rellenar el usuario*</span>";
                } else {
                    echo "<span class='error'>*Usuario repetido*</span>";
                }
            }
            ?>
        </p>
        <p>
            <label>Nombre:</label><br>
            <input type="text" name="nombre" placeholder="nombre" id="nombre" value="<?php if (isset($_POST["nombre"])) echo $_POST["nombre"]; ?>">
            <?php
            if (isset($_POST["btnGuardar"]) && $error_form) {
                if ($_POST["nombre"] == "") {
                    echo "<span class='error'>*Debes rellenar el nombre*</span>";
                }
            }
            ?>
        </p>
        <p>
            <label>Contraseña:</label><br>
            <input type="password" name="password" placeholder="password" id="password">
            <?php
            if (isset($_POST["btnGuardar"]) && $error_form) {
                if ($_POST["password"] == "") {
                    echo "<span class='error'>*Debes rellenar la contraseña*</span>";
                }
            }
            ?>
        </p>
        <p>

            <label>Dni:</label><br>
            <input type="text" name="dni" placeholder="dni" id="dni" value="<?php if (isset($_POST["dni"])) echo $_POST["dni"]; ?>">

            <?php

            if (isset($_POST["btnGuardar"]) && $error_dni) {

                if ($_POST["dni"] == "") {

                    echo "<span class='error'>*Debes rellenar el dni*</<span>";
                } elseif (!dni_bien_escrito(strtoupper($_POST["dni"]))) {

                    echo "<span class='error'>Debes rellenar el DNI con 8 digitos seguidos de una letra</<span>";

                } elseif (!dni_valido(strtoupper($_POST["dni"]))) {

                    echo "<span class='error'>El dni no es valido</<span>";

                } else {
                    echo "<span class='error'>*DNI repetido*</span>";
                }
            }

            ?>
        </p>
        <p>
            <label id="sexo">Sexo:</label><br>
            <input type="radio" name="sexo" id="hombre" value="hombre" <?php if (!isset($_POST["sexo"]) || isset($_POST["sexo"]) && $_POST["sexo"] == "hombre") echo "checked"; ?>><label for="hombre">Hombre</label><br>
            <input type="radio" name="sexo" id="mujer" value="mujer" <?php if (isset($_POST["sexo"]) && $_POST["sexo"] == "mujer") echo "checked"; ?>><label for="mujer">Mujer</label>
        </p>



        <p>
            <label for="archivo">Incluir mi foto (Max. 500KB)</label>
            <input type="file" name="archivo" id="archivo" accept="image/*">

            <?php

            if (isset($_POST["btnGuardar"]) && $error_archivo) {

                if ($_FILES["archivo"]["name"] != "") { //Si he seleccionado algo

                    if ($_FILES["archivo"]["error"]) { //Si da error

                        echo "<span class='error'>No se ha podido subir el archivo</<span>";
                    } elseif (!getimagesize($_FILES["archivo"]["tmp_name"])) { //SI no selecciona una imagen

                        echo "<span class='error'>No has seleccionado un archivo de tipo imagen</<span>";
                    } else if (!explode(".", $_FILES["archivo"]["name"])) {

                        echo "<span class='error'>El fichero subido debe tener extension</<span>";
                    } else { //SI supera el peso

                        echo "<span class='error'>El archivo seleccionado supera los 500KB</<span>";
                    }
                }
            }
            ?>
        </p>




        <p>
            <input type="checkbox" name="boletin" id="boletin" <?php if (isset($_POST["boletin"])) echo "checked"; ?>><label>Suscribirme al boletin de novedades</label><br>
        </p>
        <p>
            <button type="submit" name="btnGuardar">Guardar Cambios</button>
            <button type="submit" name="btnReset" id="btnReset">Borrar los datos introducidos</button>
        </p>



    </form>

</body>

</html>