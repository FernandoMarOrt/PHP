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
            border: 1px solid black
        }

        table {
            border-collapse: collapse;
            text-align: center
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
    </style>
</head>

<body>
    <?php
    define("SERVIDOR_BD", "localhost");
    define("USUARIO_BD", "jose");
    define("CLAVE_BD", "josefa");
    define("NOMBRE_BD", "bd_cv");

    if (!isset($conexion)) {
        try {
            $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
            mysqli_set_charset($conexion, "utf8");
        } catch (Exception $e) {
            die("<p>No ha podido conectarse a la base de batos: " . $e->getMessage() . "</p></body></html>");
        }
    }

    try {
        $consulta = "select * from usuarios";
        $resultado = mysqli_query($conexion, $consulta);
    } catch (Exception $e) {
        mysqli_close($conexion);
        die("<p>No se ha podido realizar la consulta: " . $e->getMessage() . "</p></body></html>");
    }

    echo "<table>";
    echo "<tr><th>#</th><th>Foto</th><th>Nombre</th><th>Usuario+</th></tr>";
    while ($tupla = mysqli_fetch_assoc($resultado)) {
        echo "<tr>";
        echo "<td><form action='index.php' method='post'><button class='enlace' type='submit' value='" . $tupla["id_usuario"] . "' name='btnDetalle' title='Detalles del Usuario'>" . $tupla["nombre"] . "</button></form></td>";
        echo "<td><form action='index.php' method='post'><input type='hidden' name='nombre_usuario' value='" . $tupla["nombre"] . "'><button class='enlace' type='submit' value='" . $tupla["id_usuario"] . "' name='btnBorrar'><img src='images/borrar.png' alt='Imagen de Borrar' title='Borrar Usuario'></button></form></td>";
        echo "<td><form action='index.php' method='post'><button class='enlace' type='submit' value='" . $tupla["id_usuario"] . "' name='btnEditar'><img src='images/editar.png' alt='Imagen de Editar' title='Editar Usuario'></button></form></td>";
        echo "</tr>";
    }
    echo "</table>";
    mysqli_free_result($resultado);

    ?>
</body>

</html>