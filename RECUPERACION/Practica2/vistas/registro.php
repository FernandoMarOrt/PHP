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
    $error_archivo = $_FILES["archivo"]["name"] == "" || ($_FILES["archivo"]["error"] || !explode(".", $_FILES["archivo"]["name"]) || !getimagesize($_FILES["archivo"]["tmp_name"]) || $_FILES["archivo"]["size"] > 500 * 1024);
    */
    $error_subs = !isset($_POST["boletin"]);
    $error_form = $error_usuario || $error_nombre || $error_password || $error_dni ||  $error_subs || $error_archivo;
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Practica01</title>
</head>

<body>

    <h1>Practica Rec 2</h1>
    <form action="index.php" method="post" enctype="multipart/form-data">
        <p>
            <label>Usuario:</label><br>
            <input type="text" name="usuario" placeholder="usuario" id="usuario" value="<?php if (isset($_POST["usuario"])) echo $_POST["usuario"]; ?>">
            <?php
            if (isset($_POST["btnGuardar"]) && $error_form) {
                if ($_POST["usuario"] == "") {
                    echo "<span class='error'>*Debes rellenar el usuario*</span>";
                }
            }
            ?>
        </p>
        <p>
            <label>Nombre:</label><br>
            <input type="text" name="nombre" placeholder="nombre" id="nombre" value="<?php if (isset($_POST["nombre"])) echo $_POST["nombre"]; ?>">
            <?php
            if (isset($_POST["btnGuardar"]) && $error_form) {
                if ($_POST["nombre"] == "") {
                    echo "<span class='error'>*Debes rellenar el nombre*</span>";
                }
            }
            ?>
        </p>
        <p>
            <label>Contraseña:</label><br>
            <input type="password" name="password" placeholder="password" id="password">
            <?php
            if (isset($_POST["btnGuardar"]) && $error_form) {
                if ($_POST["password"] == "") {
                    echo "<span class='error'>*Debes rellenar la contraseña*</span>";
                }
            }
            ?>
        </p>
        <p>

            <label>Dni:</label><br>
            <input type="text" name="dni" placeholder="dni" id="dni" value="<?php if (isset($_POST["dni"])) echo $_POST["dni"]; ?>">

            <?php

            if (isset($_POST["btnGuardar"]) && $error_dni) {

                if ($_POST["dni"] == "") {

                    echo "<span class='error'>*Debes rellenar el dni*</<span>";
                } elseif (!dni_bien_escrito(strtoupper($_POST["dni"]))) {

                    echo "<span class='error'>Debes rellenar el DNI con 8 digitos seguidos de una letra</<span>";
                } else {

                    echo "<span class='error'>El dni no es valido</<span>";
                }
            }

            ?>
        </p>
        <p>
            <label id="sexo">Sexo:</label><br>
            <input type="radio" name="sexo" id="hombre" value="hombre" <?php if(!isset($_POST["sexo"]) || isset($_POST["sexo"]) && $_POST["sexo"]=="hombre") echo "checked"; ?>><label for="hombre">Hombre</label><br>
            <input type="radio" name="sexo" id="mujer" value="mujer" <?php if(isset($_POST["sexo"]) && $_POST["sexo"]=="mujer") echo "checked"; ?>><label for="mujer">Mujer</label>
        </p>



        <p>
            <label for="archivo">Incluir mi foto (Max. 500KB)</label>
            <input type="file" name="archivo" id="archivo" accept="image/*">

            <?php

            if (isset($_POST["btnGuardar"]) && $error_archivo) {

                if ($_FILES["archivo"]["name"] != "") { //Si he seleccionado algo

                    if ($_FILES["archivo"]["error"]) { //Si da error

                        echo "<span class='error'>No se ha podido subir el archivo</<span>";
                    } elseif (!getimagesize($_FILES["archivo"]["tmp_name"])) { //SI no selecciona una imagen

                        echo "<span class='error'>No has seleccionado un archivo de tipo imagen</<span>";
                        
                    }else if(!explode(".",$_FILES["archivo"]["name"])){

                        echo "<span class='error'>El fichero subido debe tener extension</<span>";

                    } else { //SI supera el peso

                        echo "<span class='error'>El archivo seleccionado supera los 500KB</<span>";
                    }
                }
            }
            ?>
        </p>




        <p>
            <input type="checkbox" name="boletin" id="boletin" <?php if (isset($_POST["boletin"])) echo "checked"; ?>><label>Suscribirme al boletin de novedades</label><br>
            <?php
            if (isset($_POST["btnGuardar"]) && $error_form) {
                if (!isset($_POST["boletin"])) {
                    echo "<span class='error'>*Debes marcar la subscripcion*</span>";
                }
            }
            ?>
        </p>
        <p>
            <button type="submit" name="btnGuardar">Guardar Cambios</button>
            <button type="submit" name="btnReset" id="btnReset">Borrar los datos introducidos</button>
        </p>



    </form>

</body>

</html>