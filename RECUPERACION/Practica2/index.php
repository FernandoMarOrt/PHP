<?php

define("SERVIDOR_BD", "localhost");
define("USUARIO_BD", "jose");
define("CLAVE_BD", "josefa");
define("NOMBRE_BD", "bd_rec_cv");


session_name("Pract_2_Rec");
session_start();

if(isset($_SESSION["usuario"])){

}else{
    require "vistas/login.php";
}
?>