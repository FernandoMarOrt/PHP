<?php

//NO TOCAR

echo "<h3>Listado de los libros</h3>";
        

$url=DIR_SERV."/obtener_libros";
$respuesta=consumir_servicios_REST($url,"GET");
$obj=json_decode($respuesta);
if(!$obj)
{
    session_destroy();
    die(error_page("LIBRERIA","<h1>Libreria</h1><p>Error consumiendo el servicio: ".$url."</p>"));
}

if(isset($obj->error))
{
    session_destroy();
    die(error_page("LIBRERIA","<h1>Libreria</h1><p>".$obj->error."</p>"));
}


foreach ($obj->libros as $tupla) {
    echo "<div class='libros'>";
    echo "<img src='img/".$tupla->portada ."' alt='imagen libro' title='imagen libro'><br>";
    echo $tupla->titulo." - ".$tupla->precio."€";
    echo "</div>";
}
?>