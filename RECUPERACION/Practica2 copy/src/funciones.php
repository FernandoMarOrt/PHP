<?php

define("SERVIDOR_BD", "localhost");
define("USUARIO_BD", "jose");
define("CLAVE_BD", "josefa");
define("NOMBRE_BD", "bd_rec_cv");

define("MINUTOS", 5);

function LetraNIF($dni)
{
    return substr("TRWAGMYFPDXBNJZSQVHLCKEO", $dni % 23, 1);
}

function dni_bien_escrito($texto)
{

    return strlen($texto) == 9 && is_numeric(substr($texto, 0, 8)) && substr($texto, -1) >= "A" && substr($texto, -1) <= "Z";
}

function dni_valido($texto)
{

    return LetraNIF(substr($texto, 0, 8)) == substr($texto, -1);
}


function error_page($title, $body)
{
    $page = '<!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>' . $title . '</title>
    </head>
    <body>' . $body . '</body>
    </html>';
    return $page;
}

function repetido($conexion, $tabla, $columna, $valor)
{

    try {
        $consulta = "select " . $columna . " from " . $tabla . " where " . $columna . "=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$valor]);
        $respuesta = $sentencia->rowCount() > 0;
    } catch (Exception $e) {
        $respuesta = error_page("Práctica 2 Rec", "<h1>Práctica 2 Rec</h1><p>Imposible conectar con la base de datos: " . $e->getMessage() . "</p>");
    }
    $sentencia = null;
    return $respuesta;
}
