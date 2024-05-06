<?php

require __DIR__ . '/Slim/autoload.php';

$app= new \Slim\App;


$app->get('/obtener_libros',function(){

    $respuesta["libros"]="Hola";
    echo json_encode($respuesta);
});



$app->get('/detalles_libro/{referencia}',function($request){

    $referencia=$request->getAttribute("referencia");
    $respuesta["libros"]="Detalles del libro";
    echo json_encode($respuesta);
});


$app->delete('/borrar_libro/{referencia}',function($request){

    $referencia=$request->getAttribute("referencia");
    $respuesta["libros"]="Libro borrado con exito";
    echo json_encode($respuesta);
});



$app->put('/editar_libro/{referencia}',function($request){

    $referencia=$request->getAttribute("referencia");
    $titulo=$request->getParam("titulo");
    $autor=$request->getParam("autor");
    $respuesta["libros"]="J";
    echo json_encode($respuesta);
});




$app->post('/insertar_libro/{referencia}',function($request){

    $referencia=$request->getParam("referencia");
    $titulo=$request->getParam("titulo");
    $autor=$request->getParam("autor");
    $respuesta["libros"]="J";
    echo json_encode($respuesta);
});


$app->get('/repetido_insertar_libro/{tabla}/{columna}/{valor}',function($request){

    $tabla=$request->getParam("tabla");
    $columna=$request->getParam("columna");
    $valor=$request->getParam("valor");
    $respuesta["libros"]="J";
    echo json_encode($respuesta);
});

$app->get('/repetido_editar_libro/{tabla}/{columna}/{valor}',function($request){

    $tabla=$request->getAttribute("tabla");
    $columna=$request->getParam("columna");
    $valor=$request->getParam("valor");
    $respuesta["libros"]="J";
    echo json_encode($respuesta);
});


$app->put('/actualizar_foto/{referencia}',function($request){

    $referenca=$request->getAttribute("referenca");
    $columna=$request->getParam("columna");
    $valor=$request->getParam("valor");
    $respuesta["libros"]="J";
    echo json_encode($respuesta);
});



$app->run();

?>