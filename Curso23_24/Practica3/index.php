<?php

    if(isset($_POST["btborrar"])){
        
        unset($_POST); //SI ESTA CREADO EL $_POST LO DESTRUYE PARA QUE SE PUEDAN BORRAR LOS DATOS
    }

    if(isset($_POST["btenviar"])) { //COMPRUEBO ERRORES


        $error_nombre = $_POST["nombre"]==""; //mete en la variable error nombre , (si esta vacio mete true , y si esta relleno mete false)
        $error_apellido = $_POST["apellido"]=="";
        $error_contraseña = $_POST["contraseña"]=="";
        $error_sexo = !isset($_POST["sexo"]);  //Esto te dice si en el sexo se ha marcado alguno (!isset) eso significa SI NO SE HA MARCADO
        $error_comentarios = $_POST["comentarios"]=="";

        $error_form= $error_nombre || $error_apellido || $error_contraseña || $error_sexo ||  $error_comentarios;

        
    }

    if(isset($_POST["btenviar"]) && !$error_form) { //SI NO HAY UN ERROR EN EL FORMULARIO     

        require "vistas/vista_respuesta.php";



    }else { //SI HAY ERRORES REENVIO PARA QUE LO ARREGLE //LINEA 47 EXPLICACION , SI PONGO ESO EN EL VALUE ME DEJA EL NOMBRE SI SE RELLENA BIEN YA PUESTO

       require "vistas/vista_formulario.php";


    }


?>









