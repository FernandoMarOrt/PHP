<?php
///Consulta para traerse los libros
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica Rec 2b</title>
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

        .mensaje {
            font-size: 1.25em;
            color: blue
        }
    </style>
</head>

<body>
    <h1>Librería</h1>
    <div>
        Bienvenido <strong><?php echo $datos_usuario_log["lector"]; ?></strong> -
        <form class="en_linea" action="index.php" method="post">
            <button class="enlace" name="btnSalir" type="submit">Salir</button>
        </form>
    </div>
    <h2>Listado de Libros</h2>
    <!-- Aquí se mostrarían los libros de tres en tres -->
    <?php
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        session_destroy();
        die(error_page("Práctica Rec 2b", "<h1>Librería</h1><p>Imposible conectar a la BD. Error:" . $e->getMessage() . "</p>"));
    }


    try {

        $consulta = "SELECT * FROM libros";
        $sentencia = $conexion->prepare($consulta);
        $setencia->execute();
        $tupla = $sentencia->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        session_destroy();
        die(error_page("Libreria", "<h1>Libreria</h1><p>Imposible conectar con la base de datos</p>"));
    }

    while ($tupla) {


        echo "<p class='libros'>";
        echo "<img src='images/" . $tupla["portada"] . "' alt='imagen libro' title='imagen libro'><br>";
        echo $tupla["titulo"] . " - " . $tupla["precio"] . "€";
        echo "</p>";
    }
    $conexion = null;
    ?>
</body>

</html>