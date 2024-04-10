<?php


if (isset($_POST["btnContBorrar"])) {




    try {

        $consulta = "delete from usuarios where id_usuario=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$_POST["btnContBorrar"]]);
        if($_POST["foto"]!=FOTO_DEFECTO){
            unlink("images/".$_POST["foto"]);
        }

        $_SESSION["mensaje_accion"]="Usuario borrado con exito";
        header("Location:index.php");
        exit();

    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        session_destroy();
        die(error_page("Práctica 1º CRUD", "<h1>Práctica 1º CRUD</h1><p>No se ha podido hacer la consulta: " . $e->getMessage() . "</p>"));
    }

    $sentencia = null;
    $conexion = null;
    header("Location:index.php");
    exit();
}







try {
    $consulta = "select * from usuarios where tipo='normal'";
    $sentencia = $conexion->prepare($consulta);
    $sentencia->execute();
} catch (PDOException $e) {
    session_destroy();
    echo "<p>No se ha podido conectar con la base de datos " . $e->getMessage() . "</p></body></html>";
}
$usuarios = $sentencia->fetchAll(PDO::FETCH_ASSOC);
$sentencia = null;
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica Rec 2</title>
    <style>
        .en_linea {
            display: inline
        }

        .enlace {
            border: none;
            background: none;
            color: blue;
            text-decoration: underline;
            cursor: pointer
        }

        table,
        td,
        th {
            border: 1px solid black;
        }

        table {
            border-collapse: collapse;
            text-align: center;
            width: 70%;
        }

        table img {
            height: 100px;
        }

        img {
            height: 100px;
        }
        .mensaje{
            color: blue;
        }
    </style>
</head>

<body>
    <h1>Práctica Rec 2</h1>
    <div>
        Bienvenido <strong><?php echo $datos_usuario_log["usuario"]; ?></strong> -
        <form class="en_linea" action="index.php" method="post">
            <button class="enlace" name="btnSalir" type="submit">Salir</button>
        </form>
    </div>
    <?php



    if (isset($_POST["btnContBorrar"])) {

        echo "<p>Se dispone usted a borrar al usuario con id: <strong>" . $_POST["btnBorrar"] . "</strong></p>";
        echo "<form action='index.php' method='post'>";
        echo "<input type='hidden'  name='foto' value='" . $_POST["foto"] . "'>";
        echo "<p><button type='submit' name='btnContBorrar' value='" . $_POST["btnBorrar"] . "'>Continuar</button> ";
        echo "<button type='submit'>Atrás</button></p>";
        echo "</form>";
    }

    if(isset($_SESSION["mensaje_accion"])) {
        echo "<p class='mensaje'>".$_SESSION["mensaje_accion"]."</p>";
        unset($_SESSION["mensaje_accion"]);
    }
    echo "<h2>Listado d elos usuarios (no admin)</h2>";
    echo "<table>";
    echo "<tr>";
    echo "<td>#</td><th>Foto</th><th>Nombre</th><th><form action='index.php' method='post'><button class='enlace' name='btnNuevoUsu'>Usuario+</button></form></th>";
    foreach ($usuarios as $tupla) {
        echo "<tr>";
        echo "<td>" . $tupla["id_usuario"] . "</td>";
        echo "<td><img src='images/" . $tupla["foto"] . "'></td>";
        echo "<td><form action='index.php' method='post'><button class='enlace' name='btnDetalle' value='" . $tupla["id_usuario"] . "'>" . $tupla["nombre"] . "</form></button></td>";
        echo "<td><form action='index.php' method='post'><input type='hidden'  name='foto' value='" . $tupla["foto"] . "'><button class='enlace' name='btnBorrar' value='" . $tupla["id_usuario"] . "'>Borrar</button> - <button class='enlace'>Editar</button></form></td>";
        echo "</tr>";
    }
    echo "</tr>";
    echo "</table>";
    ?>
</body>

</html>