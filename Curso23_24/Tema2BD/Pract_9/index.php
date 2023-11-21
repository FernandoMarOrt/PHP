<?php

require "src/funciones.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table,
        td,
        th {
            border: 1px solid black;
        }

        table {
            border-collapse: collapse;
            text-align: center;
            width: 60%;
        }

        th {
            background-color: #CCC
        }

        table img {
            width: 50px;
        }

        .enlace {
            border: none;
            background: none;
            cursor: pointer;
            color: blue;
            text-decoration: underline
        }

        .error {
            color: red
        }

        .foto_detalle {
            height: 250px
        }

        .paralelo {
            display: flex
        }

        .centrado {
            text-align: center
        }
    </style>
</head>

<body>
    <h1>Videoclub</h1>
    <h2>Peliculas</h2>

    <?php

    require "vistas/vista_tabla_principal.php";

    if (isset($_POST["btnEditar"]) || isset($_POST["btnContEditar"]) || isset($_POST["btnBorrarFoto"]) || isset($_POST["btnNoBorrarFoto"]) || isset($_POST["btnContBorrarFoto"])) {
        require "vistas/vista_editar.php";
    }

    if (isset($_POST["btnDetalle"])) {
        require "vistas/vista_detalle.php";
    }

    if (isset($_POST["btnBorrar"])) {
        require "vistas/vista_conf_borrar.php";
    }

    if (isset($_POST["btnNuevaPelicula"]) || isset($_POST["btnContNuevo"])) {
        require "vistas/vista_nueva_pelicula.php";
    }




    ?>

</body>

</html>