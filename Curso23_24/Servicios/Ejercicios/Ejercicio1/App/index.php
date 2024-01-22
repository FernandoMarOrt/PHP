<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>APlicacion web de Prueba de Servicios</title>
</head>
<body>
    <?php
    define("DIR_SERV","http://localhost/Proyectos/Curso23_24/Servicios/Ejercicio1/servicios_rest");

    function consumir_servicios_REST($url,$metodo,$datos=null)
    {
        $llamada=curl_init();
        curl_setopt($llamada,CURLOPT_URL,$url);
        curl_setopt($llamada,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($llamada,CURLOPT_CUSTOMREQUEST,$metodo);
        if(isset($datos))
            curl_setopt($llamada,CURLOPT_POSTFIELDS,http_build_query($datos));
        $respuesta=curl_exec($llamada);
        curl_close($llamada);
        return $respuesta;
    }

    $datos["cod"]="YYYYYYY";
    $datos["nombre"]="producto a borrar";
    $datos["nombre_corto"]="producto a borrar";
    $datos["descripcion"]="descripcion a borrar";
    $datos["PVP"]=25.5;
    $datos["familia"]="CONSOL";

    $url=DIR_SERV."/producto/insertar";
    $respuesta=consumir_servicios_REST($url,"POST",$datos);
    $obj=json_decode($respuesta);
    if(!$obj)
        die("<p>Error consumiendo el servicio: ".$url."<p>".$respuesta);
    if(isset($obj->$mensaje_error)){
        die("<p>".$obj->$mensaje_error."<p></body></html>");
    }
    
    echo "<p>".$obj->$mensaje."</p>"

    ?>
</body>
</html>