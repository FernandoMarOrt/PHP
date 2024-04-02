<?php

define("SERVIDOR_BD", "localhost");
define("USUARIO_BD", "jose");
define("CLAVE_BD", "josefa");
define("NOMBRE_BD", "bd_rec_cv");


session_name("Pract_2_Rec");
session_start();


if (isset($_POST["btnSalir"])) {
    session_destroy();
    header("Location:index.php");
    exit;
}

if (isset($_SESSION["usuario"])) {
    //Por aquí estoy logueado

    require "src/seguridad.php";

    //He pasado los dos controles

    if ($datos_usuario_logueado["tipo"] == "admin")
        require "vistas/logueado_admin.php";
    else
        require "vistas/logueado_normal.php";

    $conexion = null;
    $sentencia = null;
} else {


    if(isset($_POST["btnRegistrarse"])){
        require "vistas/registro.php";
    }else{
        require "vistas/login.php";
    }
}
