<?php

session_name("Examen_17_18");
session_start();

require "src/ctes_func.php";

if(isset($_POST["btnSalir"])){
    session_destroy();
    header("Location:index.php");
    exit;
}

if (isset($_SESSION["usuario"])) {

    //Estoy logeado

    //Seguridad
    require "src/seguridad.php";
    //Vista oportuna
    require "vistas/vista_examen.php";

    mysqli_close($conexion);
} else {
    require "vistas/vista_login.php";
}

?>