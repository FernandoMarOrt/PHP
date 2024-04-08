<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .enlinea{display:inline}
        .enlace {
            border: none;
            background: none;
            text-decoration: underline;
            color: blue;
            cursor: pointer
        }
    </style>
</head>

<body>

    <div>Bienvenido <strong><?php echo $datos_usuario_logueado["nombre"]; ?></strong> -
        <form class='enlinea' action="index.php" method="post">
            <button class='enlace' type="submit" name="btnSalir">Salir</button>
        </form>
    </div>
    <?php
    if(isset($_SESSION["mensaje_registro"])){
        echo "<p class='mensaje'>".$_SESSION["mensaje_registro"]."</p>";
        unset($_SESSION["mensaje_registro"]);
    }
    ?>
</body>

</html>