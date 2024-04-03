<?php


if (isset($_POST["btnEntrar"])) {


    $error_usuario = $_POST["usuario"] == "";
    $error_clave = $_POST["clave"] == "";

    $error_form = $error_usuario || $error_clave;

    if (!$error_form) {


        try {
            $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        } catch (PDOException $e) {
            session_destroy();
            die(error_page("Practica Rec 2", "<h1>Practica Rec 2</h1><p>No he podido conectarse a la base de batos: " . $e->getMessage() . "</p>"));
        }

        try {
            $datos[0] = $_POST["usuario"];
            $datos[1] = md5($_POST["clave"]);
            $consulta = "select * from usuarios where usuario=? and clave=?";
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute($datos);
        } catch (PDOException $e) {
            session_destroy();
            $conexion = null;
            $sentencia = null;
            die(error_page("Practica Rec 2", "<h1>Practica Rec 2</h1><p>No he podido conectarse a la base de batos: " . $e->getMessage() . "</p>"));
        }


        if ($sentencia->rowCount() > 0) {

            $_SESSION["usuario"] = $datos[0];
            $_SESSION["clave"] = $datos[1];
            $_SESSION["ultima_accion"]=time();
            $conexion = null;
            $sentencia = null;
            header("Location:index.php");
            exit;

        } else {

            $error_usuario = true;
            $conexion = null;
            $sentencia = null;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Practica2</title>
    <style>
        .error {
            color: red
        }
        .mensaje{
            color:blue;
            font-size: 1.25rem;;
        }
    </style>
</head>

<body>
    <h1>Practica Rec 2</h1>
    <form action="index.php" method="post" enctype="multipart/form-data">
        <p>
            <label for="usuario">Usuario:</label>
            <input type="text" name="usuario" id="usuario" value="<?php if (isset($_POST["usuario"])) echo $_POST["usuario"]; ?>">
            <?php
            if (isset($_POST["btnEntrar"]) && $error_usuario) {
                if ($_POST["usuario"] == "") {
                    echo "<span class='error'>*Debes rellenar el usuario*</span>";
                } else {
                    echo "<span class='error'>*El usuario no esta en la bd*</span>";
                }
            }
            ?>
        </p>
        <p>
            <label for="clave">Contraseña:</label>
            <input type="password" name="clave" id="clave" value="">
            <?php
            if (isset($_POST["btnEntrar"]) && $error_clave) {
                echo "<span class='error'>*Debes rellenar la contraseña*</span>";
            }
            ?>
        </p>
        <button type="submit" name="btnEntrar">Entrar</button>
        <button type="submit" name="btnRegistrarse">Registrarse</button>
    </form>
    <?php
    if(isset($_SESSION["seguridad"])){  //Mensaje de seguridad por si me banean
        echo "<p class='mensaje'>".$_SESSION["seguridad"]."</p>";
        session_destroy();
    }
    ?>
</body>

</html>