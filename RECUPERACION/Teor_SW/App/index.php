<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teoría Servicios Webs</title>
</head>
<body>
    <?php
    define("DIR_SERV","http://localhost/Proyectos/PHP/RECUPERACION/Teor_SW/primera_api");

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


    $url=DIR_SERV."/saludo";
    $respuesta=consumir_servicios_REST($url,"GET");

    $json=json_decode($respuesta,true);
    if(!$json)
        die("<p>Error consumiendo el servicio: ".$url."<p>".$respuesta);

    echo "<p>El mensaje recibido ha sido <strong>".$json["mensaje"]."</strong></p>";








    
    $url=DIR_SERV."/saludo/".urlencode("María Antonia");
    $respuesta=consumir_servicios_REST($url,"GET");
    $json=json_decode($respuesta,true);
    if(!$json)
        die("<p>Error consumiendo el servicio: ".$url."<p>".$respuesta);

    echo "<p>El mensaje recibido ha sido <strong>".$json["mensaje"].    "</strong></p>";











    $url=DIR_SERV."/saludo";
    $datos["nombre"]="Juan Alonso";
    $respuesta=consumir_servicios_REST($url,"POST",$datos);
    $json=json_decode($respuesta);
    if(!$json)
        die("<p>Error consumiendo el servicio: ".$url."<p>".$respuesta);

    echo "<p>El mensaje recibido ha sido <strong>".$json->mensaje."</strong></p>";












    


    $url=DIR_SERV."/borrar_saludo/37";
    $respuesta=consumir_servicios_REST($url,"DELETE");
    $json=json_decode($respuesta);
    if(!$json)
        die("<p>Error consumiendo el servicio: ".$url."<p>".$respuesta);

    echo "<p>El mensaje recibido ha sido <strong>".$json->mensaje."</strong></p>";

    $url=DIR_SERV."/actualizar_saludo/78";
    $datos["nombre"]="Pepe Pérez";
    $respuesta=consumir_servicios_REST($url,"PUT",$datos);
    $json=json_decode($respuesta);
    if(!$json)
        die("<p>Error consumiendo el servicio: ".$url."<p>".$respuesta);

    echo "<p>El mensaje recibido ha sido <strong>".$json->mensaje."</strong></p>";
    ?>
</body>
</html>