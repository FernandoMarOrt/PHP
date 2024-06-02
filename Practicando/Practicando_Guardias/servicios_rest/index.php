<?php

require "src/funciones_servicios.php";
require __DIR__ . '/Slim/autoload.php';

$app= new \Slim\App;


$app->post("/login",function($request){

    $usuario=$request->getParam("usuario");
    $clave=$request->getParam("clave");

    echo json_encode(login($usuario,$clave));

});


$app->get("/salir",function($request){

    $api_session=$request->getParam("api_session");
    session_id($api_session);
    session_start();
    session_destroy();


    echo json_encode(array("log_out" => "Cerrando sesion en la api"));


});


$app->get("logueado",function($request){

    $api_session=$request->getParam("api_session");
    session_id($api_session);
    session_start();

    if($_SESSION["usuario"]){
        echo json_encode(login($_SESSION["usuario"],$_SESSION["usuario"]));

    }else{

        session_destroy();
        $respuesta["no_auth"]="no tiene autorizacion";
        echo json_encode($respuesta);
    }

});

   



// Una vez creado servicios los pongo a disposición
$app->run();
?>
