<?php
session_name("Practicando");
session_start();

require "src/funciones_ctes.php";


if(isset($_SESSION["usuario"])){

    require "src/seguridad.php.php";

    require "vistas/vista_normal.php";
    
}else{
    require "vistas/vista_login.php";
}

?>
