<?php


if (isset($_POST["btnEntrar"])) {

    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        session_destroy();
        die("<p>No he podido conectarse a la base de batos: " . $e->getMessage() . "</p></body></html>");
    }

    try {
        $consulta = "select * from usuarios";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute();
    } catch (PDOException $e) {
        $conexion = null;
        $sentencia = null;
        die("<p>No he podido conectarse a la base de batos: " . $e->getMessage() . "</p></body></html>");
    }

   

    if ($sentencia->rowCount() > 0) {

        $tupla = $sentencia->fetchAll(PDO::FETCH_ASSOC);

        for ($i = 0; $i < count($tupla); $i++) {
            if ($tupla[$i]["usuario"] == $_POST["usuario"] && $tupla[$i]["clave"] == $_POST["clave"]) {
                $_SESSION["usuario"] = $_POST["usuario"];
                $_SESSION["clave"] = $_POST["clave"];
            }
        }

        $conexion = null;
        $sentencia = null;
        header("Location:index.php");
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
<h1>Practica Rec 2</h1>
    <form action="index.php" method="post" enctype="multipart/form-data">
        <p>
            <label>Usuario:</label>
            <input type="text" name="usuario" id="usuario">
        </p>
        <p>
            <label>Contraseña:</label>
            <input type="password" name="clave" id="clave">
        </p>
        <button type="submit" name="btnEntrar">Entrar</button>
        <button type="submit" name="btnRegistrarse">Registrarse</button>
    </form>
</body>

</html>