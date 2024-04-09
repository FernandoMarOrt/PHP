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
    </style>
</head>

<body>
    <h1>Práctica Rec 2</h1>
    <div>
        Bienvenido <strong><?php echo $datos_usuario_log["usuario"]; ?></strong> -
        <form class="en_linea" action="index.php" method="post">
            <button class="enlace" name="btnSalir" type="submit">Salir</button>
        </form>

      

        <?php

        if (isset($_POST["btnContBorrar"])) {
            try {
                $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
            } catch (PDOException $e) {
                session_destroy();
                die(error_page("Práctica 2º CRUD", "<h1>Práctica 1º CRUD</h1><p>No he podido conectarse a la base de batos: " . $e->getMessage() . "</p>"));
            }

            try {

                $consulta = "delete from usuarios where id_usuario=?";
                $sentencia = $conexion->prepare($consulta);
                $sentencia->execute([$_POST["btnContBorrar"]]);
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


        if (isset($_POST["btnDetalle"])) {

            require "vistas/vista_detalle.php";

        } elseif (isset($_POST["btnBorrar"])) {

            require "vistas/vista_conf_borrar.php";

        } elseif (isset($_POST["btnNuevoUsu"])) {

            require "vistas/vista_nuevousu.php";
        
        }

        try {
            $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        } catch (PDOException $e) {
            session_destroy();
            echo "<p>No se ha podido conectar con la base de datos " . $e->getMessage() . "</p></body></html>";
        }


        try {
            $consulta = "select * from usuarios where tipo='normal'";
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute();
        } catch (PDOException $e) {
            session_destroy();
            echo "<p>No se ha podido conectar con la base de datos " . $e->getMessage() . "</p></body></html>";
        }

        echo "<h3>Listado de los usuarios</h3>";

        if ($sentencia->rowCount() > 0) {
            echo "<table>";
            echo "<tr>";
            echo "<td>#</td><th>Foto</th><th>Nombre</th><th><form action='index.php' method='post'><button class='enlace' name='btnNuevoUsu'>Usuario+</button></form></th>";
            echo "</tr>";
            while ($tupla = $sentencia->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . $tupla["id_usuario"] . "</td>";
                echo "<td><img src='images/" . $tupla["foto"] . "'></td>";
                echo "<td><form action='index.php' method='post'><button class='enlace' name='btnDetalle' value='" . $tupla["id_usuario"] . "'>" . $tupla["nombre"] . "</form></button></td>";
                echo "<td><form action='index.php' method='post'><button class='enlace' name='btnBorrar' value='" . $tupla["id_usuario"] . "'>Borrar</button> - <button class='enlace'>Editar</button></form></td>";
                echo "</tr>";
            }
            echo "</table>";
        }

        ?>
    </div>
</body>

</html>