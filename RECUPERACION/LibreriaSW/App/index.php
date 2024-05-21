<?php
//Pasado a SW
session_name("Examen3_Pract_Rec_23_24_SW");
session_start();

require "src/funciones_ctes.php";

if(isset($_POST["btnSalir"]))
{
    $datos_env["api_key"]=$_SESSION["api_key"];
    session_destroy();

    consumir_servicios_REST(DIR_SERV."/salir","POST",$datos_env);
    header("Location:index.php");
    exit();
}

if(isset($_SESSION["usuario"]))
{
    $salto="index.php";
    require "src/seguridad.php";

    if($datos_usuario_log["tipo"]=="normal")
        
        require "vistas/vista_normal.php";
    else

    header("Location:admin/gest_libros.php");
    exit;
    $conexion=null;
}else
{
    require "vistas/vista_home.php";
}

?>