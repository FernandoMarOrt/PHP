<?php
session_name("Examen3_Pract_Rec_23_24_SW");
session_start();

require "../src/funciones_ctes.php";

if(isset($_POST["btnSalir"]))
{
    session_destroy();
    header("Location:../index.php");
    exit;
}



if(isset($_SESSION["usuario"]))
{

    try{
        $conexion=mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NOMBRE_BD);
        mysqli_set_charset($conexion,"utf8");
    }
    catch(Exception $e)
    {
        session_destroy();
        die(error_page("Examen3 Curso 23-24","<h1>Librería</h1><p>No he podido conectarse a la base de batos: ".$e->getMessage()."</p>"));
    }

    require "../src/seguridad.php";
    
    if($datos_usuario_log["tipo"]=="admin")
    {
        require "../vistas/vista_admin.php";
    }
    else
    {
        header("Location:../index.php");
        exit;
    }
}
else
{
    header("Location:../index.php");
    exit();
}