<?php

try {
    $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
} catch (PDOException $e) {
    session_destroy();
    die("<p>No he podido conectarse a la base de batos: " . $e->getMessage() . "</p></body></html>");
}

try {
    $consulta = "select * from usuarios where usuario='" . $_SESSION["usuario"] . "' and clave='" . $_SESSION["clave"] . "'";
    $sentencia = $conexion->prepare($consulta);
    $sentencia->execute();
} catch (PDOException $e) {
    $conexion = null;
    $sentencia = null;
    die("<p>No he podido conectarse a la base de batos: " . $e->getMessage() . "</p></body></html>");
}


$datos_usuario_logueado = $sentencia->fetch(PDO::FETCH_ASSOC);

?>