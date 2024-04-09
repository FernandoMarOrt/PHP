<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .enlinea {
            display: inline
        }

        .enlace {
            border: none;
            background: none;
            text-decoration: underline;
            color: blue;
            cursor: pointer
        }

        table,td,th{border:1px solid black;}
            table{border-collapse:collapse;text-align:center;width:70%;margin:0 auto}
            table img{height:100px;}
    </style>
</head>

<body>

    <div>Bienvenido <strong><?php echo $datos_usuario_logueado["nombre"]; ?></strong> -
        <form class='enlinea' action="index.php" method="post">
            <button class='enlace' type="submit" name="btnSalir">Salir</button>
        </form>
    </div>


    <h3>Listado de los usuarios</h3>


    <?php
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


    if($sentencia->rowCount()>0){
        echo "<table>";
        echo "<tr>";
        echo "<td>#</td><th>Foto</th><th>Nombre</th><th>Usuario</th>";
        echo "</tr>";
        while ($tupla = $sentencia->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . $tupla["id_usuario"] . "</td>";
            echo "<td><img src='images/".$tupla["foto"]."'></td>";
            echo "<td>" . $tupla["nombre"] . "</td>";
            echo "<td>" . $tupla["usuario"] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
  
    ?>
</body>

</html>