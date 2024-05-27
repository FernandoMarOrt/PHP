<!-- NO TOCAR -->
<?php

$dia_semana = date("w");


switch (date("w")) {
    case 1:
        $dia_semana = "Lunes";
        break;
    case 2:
        $dia_semana = "Martes";
        break;
    case 3:
        $dia_semana = "Miercoles";
        break;
    case 4:
        $dia_semana = "Jueves";
        break;
    case 5:
        $dia_semana = "Viernes";
        break;
}





?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion de Guardias</title>
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

        img {
            height: 200px
        }

    </style>
</head>

<body>
    <h1>Gestion de Guardias</h1>

    <div>Bienvenido <strong><?php echo $datos_usuario_log["usuario"]; ?></strong> -
        <form class='enlinea' action="index.php" method="post">
            <button class='enlace' type="submit" name="btnSalir">Salir</button>
        </form>
    </div>
    <h4>Hoy es <?php echo $dia_semana;  ?></h4>

</body>

</html>