<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>img{width:35%}</style>
</head>
<body>
    <h1>DATOS ENVIADOS</h1>
    
    <?php

    echo "<p>Usuario: " .$_POST["usuario"]."</p>";
    echo "<p>DNI: " .$_POST["dni"]."</p>";

    echo "<p>.............</p>";

    echo "<p><strong>Foto</strong></p>";


    if($_FILES["archivo"]["name"]!=""){
        $array_ext=explode(".",$_FILES["archivo"]["name"]);
        $ext=".".strtolower(end($array_ext));
        $nombre_nuevo='imagen'.$ext;
        @$var=move_uploaded_file($_FILES["archivo"]["tmp_name"],"images/".$nombre_nuevo);
        if($var){ //LO DEL @$var y esto es porque si no pega un error raro

            echo "<p>Nombre: ".$_FILES["archivo"]["name"]."</p>";
            echo "<p>Tipo: ".$_FILES["archivo"]["type"]."</p>";
            echo "<p>Tamaño: ".$_FILES["archivo"]["size"]."</p>";
            echo "<p>La imagen se ha movido con exito".$_FILES["archivo"]["tmp_name"]."</p>";
            echo "<p><img class='tam_imag' src='images/".$nombre_nuevo."' alt='Foto' title='Foto' /></p>";
    
        }else{
            echo "<p><strong>Foto:</strong>No se ha podido mover la imagen seleccionada a la carpeta de destino</p>";
        }
    }else{

        echo "<p><strong>Foto: </strong>Imagen no seleccionada</p>";
    }
    ?>
</body>
</html>