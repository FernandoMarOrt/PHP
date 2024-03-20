<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Practica 2</title>
    <style>
        .oculta {
            display: none;
        }

        .error {
            color: red;
        }
    </style>
</head>

<body>
    <h1>Segundo Formulario</h1>

    <form action="index.php" method="post" enctype="multipart/form-data">

        <p><label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" value="<?php if (isset($_POST['nombre'])) echo $_POST['nombre'] ?>">
            <?php
            if (isset($_POST["enviar"]) && $errorNombre) {
                echo "<span class='error'>* Campo obligatorio *</span>";
            }
            ?>
        </p>

        <p>Nacido en:
            <select name="nacimiento" id="nacimiento">
                <option value="Malaga" <?php if (isset($_POST["nacimiento"]) && $_POST["nacimiento"] == "Malaga") echo "selected" ?>>Málaga</option>
                <option value="Cadiz" <?php if (isset($_POST["nacimiento"]) && $_POST["nacimiento"] == "Cadiz") echo "selected" ?>>Cadiz</option>
                <option value="Granada" <?php if (isset($_POST["nacimiento"]) && $_POST["nacimiento"] == "Granada") echo "selected" ?>>Granada</option>
            </select>
        </p>

        Sexo: <label for="hombre">Hombre</label>
        <input type="radio" name="sexo" id="hombre" value="hombre" <?php if (isset($_POST["sexo"]) && $_POST["sexo"] == "hombre") echo "checked" ?>>
        <label for="mujer">Mujer</label>
        <input type="radio" name="sexo" id="mujer" value="mujer" <?php if (isset($_POST["sexo"]) && $_POST["sexo"] == "mujer") echo "checked" ?>>

        <?php
        if (isset($_POST["enviar"]) && $errorSexo) {
            echo "<span class='error'>* Campo obligatorio *</span>";
        }
        ?>
        </br>

        <p>Aficiones:
            <label for="deportes">Deportes</label>
            <input type="checkbox" name="aficiones[]" id="deportes" value="deportes" <?php if (isset($_POST["aficiones"]) && en_array("deportes", $_POST["aficiones"])) echo "checked"; ?> />
            <label for="lectura">Lectura</label>
            <input type="checkbox" name="aficiones[]" id="lectura" value="lectura" <?php if (isset($_POST["aficiones"]) && en_array("lectura", $_POST["aficiones"])) echo "checked"; ?> />
            <label for="otros">Otros</label>
            <input type="checkbox" name="aficiones[]" id="otros" value="otros" <?php if (isset($_POST["aficiones"]) && en_array("otros", $_POST["aficiones"])) echo "checked"; ?> />
        </p>



        <p>
            <label for="comentario">Comentarios:</label>
            <textarea id="comentario" name="comentario"></textarea>
            <?php
            if (isset($_POST["enviar"]) && $errorComentario) {
                echo "<span class='error'>* Campo obligatorio *</span>";
            }
            ?>
        </p>

        <p>
            <label for="archivo">Incluir mi foto (Archivo de tipo imagen Máx. 500KB):</label>
            <button onclick='document.getElementById("archivo").click();return false;'>Seleccionar archivo</button>
            <input id="archivo" class="oculta" onchange="document.getElementById('nombre_archivo').innerHTML=' '+document.getElementById('archivo').files[0].name+' ';" type="file" name="archivo" accept="image/*">
            <span id="nombre_archivo"></span>
            <?php

            if (isset($_POST["enviar"]) && $error_archivo) {

                if ($_FILES["archivo"]["name"] == "") {
                    echo "<span class='error'>*Error: Debe subir un archivo*</<span>";
                } elseif ($_FILES["archivo"]["error"]) { //Si da error

                    echo "<span class='error'>No se ha podido subir el archivo</<span>";
                } elseif (!getimagesize($_FILES["archivo"]["tmp_name"])) { //SI no selecciona una imagen

                    echo "<span class='error'>No has seleccionado un archivo de tipo imagen</<span>";
                } else if (!explode(".", $_FILES["archivo"]["name"])) {

                    echo "<span class='error'>El fichero subido debe tener extension</<span>";
                } else { //SI supera el peso

                    echo "<span class='error'>El archivo seleccionado supera los 500KB</<span>";
                }
            }
            ?>
        </p>

        <button type="submit" name="enviar">Enviar</button>
        <button type="submit" name="borrar">Borrar Campos</button>
    </form>
</body>

</html>