<?php
require "src/ctes_funciones.php";
if (isset($_POST["btnContBorrar"])) {

    try {
        $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
        mysqli_set_charset($conexion, "utf8");
    } catch (Exception $e) {
        die(error_page("<h1>Práctica 8", "</h1><p>No ha podido conectarse a la base de batos: " . $e->getMessage() . "</p>"));
    }

    try {
        $consulta = "delete from usuarios where id_usuario='" . $_POST["btnContBorrar"] . "'";
        mysqli_query($conexion, $consulta);
    } catch (Exception $e) {
        mysqli_close($conexion);
        die(error_page("<h1>Práctica 8", "</h1><p>No ha podido conectarse a la base de batos: " . $e->getMessage() . "</p>"));
    }


    if ($_POST["nombre_foto"] != "no_imagen.jpg") {
        unlink("img/" . $_POST["nombre_foto"]);
    }

    mysqli_close($conexion);
    header("Location:index.php");
    exit();
}
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
            width: 50%;
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
            color: red;
        }

        .foto_detalle {
            width: 20%;
        }
    </style>
</head>

<body>
    <?php
    if (isset($_POST["btnDetalle"])) {

        require "vistas/vistas_detalle.php";
    }

    if (isset($_POST["btnBorrar"])) {
        require "vistas/vistas_borrar.php";
    }


    if (isset($_POST["btnNuevoUsuario"])) {

    ?>
        <h1>Agregar Nuevo Usuario</h1>
        <form action="index.php" method="post">
            <p>
                <label for="nombre">Nombre: </label><br />
                <input type="text" name="nombre" id="nombre" maxlength="30" placeholder="Nombre..." value="<?php if (isset($_POST["nombre"])) echo $_POST["nombre"]; ?>">
                <?php
                if (isset($_POST["btnContInsertar"]) && $error_nombre) {
                    if ($_POST["nombre"] == "")
                        echo "<span class='error'> Campo vacío</span>";
                    else
                        echo "<span class='error'> Has tecleado más de 30 caracteres</span>";
                }
                ?>
            </p>
            <p>
                <label for="usuario">Usuario: </label><br />
                <input type="text" name="usuario" id="usuario" maxlength="20" placeholder="Usuario..." value="<?php if (isset($_POST["usuario"])) echo $_POST["usuario"]; ?>">
                <?php
                if (isset($_POST["btnContInsertar"]) && $error_usuario) {
                    if ($_POST["usuario"] == "")
                        echo "<span class='error'> Campo vacío</span>";
                    elseif (strlen($_POST["usuario"]) > 20)
                        echo "<span class='error'> Has tecleado más de 20 caracteres</span>";
                    else
                        echo "<span class='error'> Usuario repetido</span>";
                }
                ?>
            </p>
            <p>
                <label for="clave">Contraseña: </label><br />
                <input type="password" name="clave" maxlength="15" placeholder="Contraseña..." id="clave">
                <?php
                if (isset($_POST["btnContInsertar"]) && $error_clave) {
                    if ($_POST["clave"] == "")
                        echo "<span class='error'> Campo vacío</span>";
                    else
                        echo "<span class='error'> Has tecleado más de 15 caracteres</span>";
                }
                ?>
            </p>
            <p>
                <label for="DNI">DNI: </label><br />
                <input type="text" name="DNI" id="DNI" maxlength="50" placeholder="DNI. 11223344Z" value="<?php if (isset($_POST["DNI"])) echo $_POST["DNI"]; ?>">

            </p>

            <p>
                Sexo:
                <?php
                if (isset($_POST["btnContInsertar"]) && $error_sexo) {
                    echo "<span class='error'>Debes seleccionar uno</span>";
                }
                ?>
                <br>
                <input type="radio" name="sexo" id="hombre" value="Hombre" <?php if (isset($_POST["sexo"]) && $_POST["sexo"] == "Hombre") echo "checked"; ?>><label for="">Hombre</label><br>
                <input type="radio" name="sexo" id="mujer" value="Mujer" <?php if (isset($_POST["sexo"]) && $_POST["sexo"] == "Mujer") echo "checked"; ?>><label>Mujer</label><br>
            </p>
            <p>
                <label for="archivo">Seleccione un archivo imagen (Max 500KB):</label>
                <input type="file" name="archivo" id="archivo" accept="img/*" />
                <?php
                if (isset($_POST["btnContInsertar"]) && $error_archivo) {
                    if ($_FILES["archivo"]["name"] != "") {
                        if ($_FILES["archivo"]["error"]) {
                            echo "<span class='error'>No se ha podido subir el archivo</span>";
                        } elseif (!getimagesize($_FILES["archivo"]["tmp_name"])) {
                            echo "<span class='error'>No has selecionado un archivo tipo img</span>";
                        } else {
                            echo "<span class='error'>El archivo supera el tamaño</span>";
                        }
                    }
                }
                ?>
            </p>

            <p>
                <button type="submit" name="btnContInsertar">Guardar Cambios</button>
                <button type="submit">Atras</button>
            </p>
        </form>

    <?php

       
    }

    require "vistas/vistas_tablaP.php";


    ?>
</body>

</html>