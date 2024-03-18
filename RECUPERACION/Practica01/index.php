<?php

require "src/funciones.php";

if (isset($_POST["btnGuardar"])) {

    $error_usuario = $_POST["usuario"] == "";
    $error_nombre = $_POST["nombre"] == "";
    $error_password = $_POST["password"] == "";
    $error_dni = $_POST["dni"] == "" || !dni_bien_escrito(strtoupper($_POST["dni"]));
    $error_archivo = $_FILES["archivo"]["name"] != "" && ($_FILES["archivo"]["error"] || !getimagesize($_FILES["archivo"]["tmp_name"]) || $_FILES["archivo"]["size"] > 500 * 1024);


    $error_form = $error_usuario || $error_nombre || $error_password || $error_dni || !$_POST["boletin"] || $error_archivo;
}


if (isset($_POST["btnGuardar"]) && !$error_form) {


    require "vistas/vistasRespuestas.php";

} else {


    require "vistas/vistasFormulario.php";

  
}

?>