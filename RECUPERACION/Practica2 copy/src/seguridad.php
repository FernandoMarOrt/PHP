<?php

try {
    $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
} catch (PDOException $e) {
    session_destroy();
    die(error_page("Practica Rec 2", "<h1>Practica Rec 2</h1><p>No he podido conectarse a la base de batos: " . $e->getMessage() . "</p>"));
}

try {
    $datos[0] = $_SESSION["usuario"];
    $datos[1] = $_SESSION["clave"];
    $consulta = "select * from usuarios where usuario=? and clave=?";
    $sentencia = $conexion->prepare($consulta);
    $sentencia->execute($datos);
} catch (PDOException $e) {
    session_destroy();
    $conexion = null;
    $sentencia = null;
    die(error_page("Practica Rec 2", "<h1>Practica Rec 2</h1><p>No he podido conectarse a la base de batos: " . $e->getMessage() . "</p>"));
}


if ($sentencia->rowCount() <= 0) {


    $conexion = null;
    $sentencia = null;
    session_unset();
    $_SESSION["seguridad"] = "Usted ya no se encuentra registrado en la BD";
    header("Location:index.php");
    exit();
}

//PASO CONTROL DE BANEO
$datos_usuario_logueado = $sentencia->fetch(PDO::FETCH_ASSOC);

$sentencia = null;

if (time() - $_SESSION["ultima_accion"] > MINUTOS * 60) {
    $conexion = null;
    session_unset();
    $_SESSION["seguridad"] = "Su tiempo de sesion ha expirado. Por favor vuelva a loguearse";
    header("Location:index.php");
    exit();
}

//PASO EL CONTROL DE TIEMPO y lo renuevo

$_SESSION["ultima_accion"] = time();
?>