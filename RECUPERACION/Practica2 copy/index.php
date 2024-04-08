<?php

session_name("Pract_2_Rec");
session_start();

require "src/funciones.php";

if (isset($_POST["btnSalir"])) {
    session_destroy();
    header("Location:index.php");
    exit();
}

if (isset($_SESSION["usuario"])) {
    //Por aquí estoy logueado

    require "src/seguridad.php";

    if ($datos_usuario_logueado["tipo"] == "admin")

        require "vistas/logueado_admin.php";
    else
        require "vistas/logueado_normal.php";

    

    $conexion=null;

} elseif (isset($_POST["btnRegistrarse"]) || isset($_POST["btnReset"]) || isset($_POST["btnGuardar"])) {

    require "vistas/vista_registro.php";
} else {

    require "vistas/vista_home.php";
}
