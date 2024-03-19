<?php

require "src/funciones.php";


if (isset($_POST["btnReset"])) {

    unset($_POST); //SI ESTA CREADO EL $_POST LO DESTRUYE PARA QUE SE PUEDAN BORRAR LOS DATOS
}

if (isset($_POST["btnGuardar"])) {

    $error_usuario = $_POST["usuario"] == "";
    $error_nombre = $_POST["nombre"] == "";
    $error_password = $_POST["password"] == "";
    $error_dni = $_POST["dni"] == "" || !dni_bien_escrito(strtoupper($_POST["dni"])) || !dni_valido(strtoupper($_POST["dni"]));
    
    
    
    /*Foto no obligatoria*/
    $error_archivo = $_FILES["archivo"]["name"] != "" && ($_FILES["archivo"]["error"] || !explode(".", $_FILES["archivo"]["name"]) || !getimagesize($_FILES["archivo"]["tmp_name"]) || $_FILES["archivo"]["size"] > 500 * 1024);

    /*Foto obligatoria*
    $error_archivo = $_FILES["archivo"]["name"] != "" || ($_FILES["archivo"]["error"] || !explode(".", $_FILES["archivo"]["name"]) || !getimagesize($_FILES["archivo"]["tmp_name"]) || $_FILES["archivo"]["size"] > 500 * 1024);
    */
    $error_subs = !isset($_POST["boletin"]);

    $error_form = $error_usuario || $error_nombre || $error_password || $error_dni ||  $error_subs || $error_archivo;
}


if (isset($_POST["btnGuardar"]) && !$error_form) {


    require "vistas/vistasRespuestas.php";
} else {


    require "vistas/vistasFormulario.php";
}
