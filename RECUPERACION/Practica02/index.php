<?php



if (isset($_POST["borrar"])) {

    unset($_POST); //SI ESTA CREADO EL $_POST LO DESTRUYE PARA QUE SE PUEDAN BORRAR LOS DATOS
}

function en_array($valor, $arr) //Esta funcion mira en el array que hemos puesto en el campo de aficiones (aficiones[] asi se crea el array)
{                              //Y lo recorre para saber si esta un valor determinado si esta ese valor devuelve true 
    $esta = false;

    for ($i = 0; $i < count($arr); $i++) {

        if ($arr[$i] == $valor) {

            $esta = true;
            break;
        }
    }

    return $esta;
}

if (isset($_POST["enviar"])) {

    //SI LOS CAMPOS DE REQUERIDO SE PONEN VACIOS
    $errorNombre = $_POST["nombre"] == "";
    $errorSexo = !isset($_POST["sexo"]);
    $errorComentario = $_POST["comentario"] == "";

    $error_archivo = $_FILES["archivo"]["name"] == "" || ($_FILES["archivo"]["error"] || !explode(".", $_FILES["archivo"]["name"]) || !getimagesize($_FILES["archivo"]["tmp_name"]) || $_FILES["archivo"]["size"] > 500 * 1024);

    $errorFormu = $errorNombre || $errorSexo || $errorComentario || $error_archivo;
}

//SI NO TIENE ERRORES Y SE PULSA EL BOTON

if (isset($_POST["enviar"]) && !$errorFormu) {
    require "vistas/vistasRespuestas.php";
} else {
    require "vistas/vistasFormulario.php";
}
