<?php
 if(isset($_POST["btenviar"])){

    ?>
        <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recogida</title>
    <style>.tam_imag{width:35%}</style>
</head>

<body>
    <h1>RECOGIDA DE DATOS</h1>
    <?php


    echo "<p><strong>Nombre: </strong>" .$_POST["nombre"]."</p>";
    echo "<p><strong>Apellidos: </strong>" .$_POST["apellido"]."</p>";
    echo "<p><strong>Contraseña: </strong>" .$_POST["contraseña"]."</p>";
    echo "<p><strong>dni: </strong>" .$_POST["dni"]."</p>";
    echo "<p><strong>Sexo: </strong>" .$_POST["sexo"]."</p>";

    $nombre_nuevo=md5(uniqid(uniqid(),true));//GENERA UN NUMERO UNICO
    $array_nombre=explode(".",$_FILES["archivo"]["name"]);
    $extension="";//PARA EXTENSION VACIA
    if(count($array_nombre)>1){ //SI NO LLEVA EXTENSION

        $extension=".".end($array_nombre);
                        
    }
    $nombre_nuevo.=".".$extension; //CONCATENACION DE NOMBRE NUEVO Y EXTENSION .= ES PARA CONCATENAR 2 STRINGS
    @$var=move_uploaded_file($_FILES["archivo"]["tmp_name"],"images/".$nombre_nuevo); //PARA MOVER LA IMAGEN SUBIDA A OTRO SITIO
    if($var){ //LO DEL @$var y esto es porque si no pega un error raro

        echo "<h3>Foto</h3>";
        echo "<p><strong>Nombre: </strong>".$_FILES["archivo"]["name"]."</p>";
        echo "<p><strong>Tipo: </strong>".$_FILES["archivo"]["type"]."</p>";
        echo "<p><strong>Tamaño: </strong>".$_FILES["archivo"]["size"]."</p>";
        echo "<p><strong>Error: </strong>".$_FILES["archivo"]["error"]."</p>";
        echo "<p><strong>Archivo en el temporal del servidor: </strong>".$_FILES["archivo"]["tmp_name"]."</p>";
        echo "<p><img class='tam_imag' src='images/".$nombre_nuevo."' alt='Foto' title='Foto' /></p>";

    }
    
    echo "<p><strong>Nacido en: </strong>" .$_POST["nacido"]."</p>";
    echo "<p><strong>Comentarios: </strong>" .$_POST["comentarios"]."</p>";


    if(isset($_POST["subscripcion"])){ //el isset es para decir si ha seleccionado sexo te devuelve true y si no false


        echo "<p><strong>Subscripcion: </strong> Si </p>";

    }else {

        echo "<p><strong>Subscripcion: </strong> No</p>";
    }

    ?>
</body>
</html>

    <?php

    

 }else {

    header("Localtion:index.php");

 }
?>




