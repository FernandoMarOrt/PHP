<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Practica 2</title>
    <style>img{width: 35%;}</style>
</head>

<body>
    <h1>Estos son los datos enviados</h1>


    <?php

    echo "<p>El nombre enviado ha sido: " . $_POST["nombre"] . " </p>";
    echo "<p>Ha nacido en: " . $_POST["nacimiento"] . " </p>";

    if (isset($_POST["sexo"])) {
        echo "<p>El sexo es: " . $_POST["sexo"] . " </p>";
    } else {
        echo "<p>El sexo es: Vacio </p>";
    }

    //AFICIONES
    if (!isset($_POST["aficiones"])) {

        echo "<p>No has selccionada ninguna aficion</p>";
    } elseif (count($_POST["aficiones"]) == 1) {

        echo "<p>Las aficiones seleccionadas han sido:</p>";
        echo "<ol>";
        echo "<li>" . $_POST["aficiones"][0] . "</li>";
        echo "</ol>";
    } else {

        echo "<p>Las aficiones seleccionadas han sido:</p>";
        echo "<ol>";
        for ($i = 0; $i < count($_POST["aficiones"]); $i++) {

            echo "<li>" . $_POST["aficiones"][$i] . "</li>";
        }
        echo "</ol>";
    }


    if ($_POST["comentario"] != "") {
        echo "<p>El comentario enviado ha sido: " . $_POST["comentario"] . "</p>";
    } else {
        echo "<p>No has hecho ningún comentario</p>";
    }



    if ($_FILES["archivo"]["name"] != "") {
        $array_ext = explode(".", $_FILES["archivo"]["name"]);
        $ext = "." . strtolower(end($array_ext));
        $nombre_nuevo = 'imagen' . $ext;
        @$var = move_uploaded_file($_FILES["archivo"]["tmp_name"], "images/" . $nombre_nuevo);
        if ($var) { //LO DEL @$var y esto es porque si no pega un error raro

            echo "<h3>Informacion de la imagen seleccionada</h3>";
            echo "<p>Error: ".$_FILES["archivo"]["error"]."</p>";
            echo "<p>Nombre: " . $_FILES["archivo"]["name"] . "</p>";
            echo "<p>Ruta en servidor: " . $_FILES["archivo"]["tmp_name"] . "</p>";
            echo "<p>Tipo: " . $_FILES["archivo"]["type"] . "</p>";
            echo "<p>Tamaño: " . $_FILES["archivo"]["size"] . "</p>";
            echo "<p><img class='tam_imag' src='images/" . $nombre_nuevo . "' alt='Foto' title='Foto' /></p>";

        } else {

            echo "<p><strong>Foto:</strong>No se ha podido mover la imagen seleccionada a la carpeta de destino</p>";
            
        }
    } else {

        echo "<p><strong>Foto: </strong>Imagen no seleccionada</p>";
    }




    ?>

</body>

</html>