<?php

require __DIR__ . '/Slim/autoload.php';

$app= new \Slim\App;


require  "src/funciones_api.php";


$app->post('/insertar_usuario',function($request){

    $datos[]=$request->getParam("nombre");
    $datos[]=$request->getParam("usuario");
    $datos[]=$request->getParam("clave");
    $datos[]=$request->getParam("dni");
    $datos[]=$request->getParam("sexo");
    $datos[]=$request->getParam("subscripcion");


    $respuesta["libros"]="J";
    echo json_encode(insertar_usuario($datos));
});



$app->put('/actualizar_foto/{id_usuario}',function($request){

    $datos[]=$request->getParam("foto");
    $datos[]=$request->getAttribute("id_usuario");


    echo json_encode(actualizar_foto($datos));
});




$app->get('/repetido_insert/{tabla}/{columna}/{valor}',function($request){

    $tabla=$request->getAttribute("tabla");
    $columna=$request->getAttribute("columna");
    $valor=$request->getAttribute("valor");


    echo json_encode(repetido_insertando($tabla,$columna,$valor));
});



$app->get('/repetido_edit/{tabla}/{columna}/{valor}/{columna_clave}/{valor_clave}',function($request){

    $tabla=$request->getAttribute("tabla");
    $columna=$request->getAttribute("columna");
    $valor=$request->getAttribute("valor");
    $columna_clave=$request->getAttribute("columna_clave");
    $valor_clave=$request->getAttribute("valor_clave");


    echo json_encode(repetido_insertando($tabla,$columna,$valor,$columna_clave,$valor_clave));
});





$app->get('/obtener_usuarios',function(){
    echo json_encode(obtener_todos_usuarios());
});



$app->get('/obtener_usuarios_pag/{pag}/{n_registros}',function($request){
    echo json_encode(obtener_todos_usuarios_pag($request->getAttribute("pag"),$request->getAttribute("n_registros")));
});


$app->get('/obtener_usuarios_filtros',function($request){
    echo json_encode(obtener_todos_usuarios_filtro($request->getParam("buscar")));
});




$app->get('/obtener_usuarios_filtro_pag/{pag}/{n_registros}',function($request){
    echo json_encode(obtener_todos_usuarios_filtro_pag($request->getAttribute("pag"),$request->getAttribute("n_registros"),$request->getParam("buscar")));
});


$app->get('/obtener_detalles/{id_usuario}',function($request){
    echo json_encode(obtener_detalles_usuario($request->getAttribute("id_usuario")));
});



$app->delete('/borrar_usuario/{id_usuario}',function($request){
    echo json_encode(borrar_usuario($request->getAttribute("id_usuario")));
});



$app->put('/actualizar_usuario_clave/{id_usuario}',function($request){

    $datos[]=$request->getParam("nombre");
    $datos[]=$request->getParam("usuario");
    $datos[]=$request->getParam("clave");
    $datos[]=$request->getParam("dni");
    $datos[]=$request->getParam("sexo");
    $datos[]=$request->getParam("subscripcion");
    $datos[]=$request->getAttribute("id_usuario");


    $respuesta["libros"]="J";
    echo json_encode(actualizar_usuario_clave($datos));
});


$app->put('/actualizar_usuario_sin_clave/{id_usuario}',function($request){

    $datos[]=$request->getParam("nombre");
    $datos[]=$request->getParam("usuario");
    $datos[]=$request->getParam("dni");
    $datos[]=$request->getParam("sexo");
    $datos[]=$request->getParam("subscripcion");
    $datos[]=$request->getAttribute("id_usuario");


    $respuesta["libros"]="J";
    echo json_encode(actualizar_usuario_sin_clave($datos));
});

$app->run();

?>