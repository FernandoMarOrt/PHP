<?php

$datos_env["api_session"]=$_SESSION["api_session"];
$respuesta=consumir_servicios_REST(DIR_SERV."/logueado","GET");
$json=json_encode($respuesta,true);


if(!$json){

    session_destroy();
    die(error_page("Examen","<h1>Examen</h1><p>Sin respuesta oportuna en la api</p>"));

}

if(isset($json["error_bd"])){

    session_destroy();
    $respuesta=consumir_servicios_REST(DIR_SERV."/salir","POST");
    die(error_page("Examen","<h1>Examen</h1><p>".$json["error_bd"]."</p>"));
    
}

if(isset($json["no_auth"])){

    session_unset();
    $_SESSION["seguridad"]="Usted ya no tiene acceso a la api";
    header("Location:index.php");
    exit();
    
}

if(isset($json["mensaje"])){

    session_unset();
    $respuesta=consumir_servicios_REST(DIR_SERV."/salir","POST");
    $_SESSION["seguridad"]="Usted ya no tiene acceso a la api";
    header("Location:index.php");
    exit();
    
}

$datos_usuarios_log=$_SESSION["usuario"];

if(time()-$_SESSION["ultima-accion"]>MINUTOS*60){

    session_unset();
    $respuesta=consumir_servicios_REST(DIR_SERV."/salir","POST");
    $_SESSION["seguridad"]="Usted ya no tiene acceso a la api";
    header("Location:index.php");
    exit();

}

$_SESSION["ultima-accion"]=time();
?>