<!-- NO TOCAR -->
<?php

$dia = date("w");


switch (date("w")) {
    case 1:
        $dia = "Lunes";
        break;
    case 2:
        $dia = "Martes";
        break;
    case 3:
        $dia = "Miercoles";
        break;
    case 4:
        $dia = "Jueves";
        break;
    case 5:
        $dia = "Viernes";
        break;
}

$horas[1] = "8:15 - 9:15";
$horas[2] = "9:15 - 10:15";
$horas[3] = "10:15 - 11:15";
$horas[4] = "11:15 - 11:45";
$horas[5] = "11:45 - 12:45";
$horas[6] = "12:45 - 13:45";
$horas[7] = "13:45 - 14:45";

$dia_hoy = date("w");


for ($hora = 1; $hora <= count($horas); $hora++) {
    if ($hora != 4) {


        $respuesta = consumir_servicios_REST(DIR_SERV . "/usuariosGuardia/".$dia_hoy."/".$hora,"GET", $datos_env);
        $json = json_decode($respuesta, true);

        if (!$json) {
            session_destroy();
            die(error_page("Práctica Rec 3", "<h1>Práctica Rec 3</h1><p>Sin respuesta oportuna de la API</p>"));
        }
        if (isset($json["error_bd"])) {

            session_destroy();
            consumir_servicios_REST(DIR_SERV . "/salir", "POST", $datos_env);
            die(error_page("Práctica Rec 3", "<h1>Práctica Rec 3</h1><p>" . $json["error_bd"] . "</p>"));
        }

        if (isset($json["no_auth"])) {
            session_unset();
            $_SESSION["seguridad"] = "Usted ha dejado de tener acceso a la API. Por favor vuelva a loguearse.";
            header("Location:index.php");
            exit();
        }


        $profesores_guardia[$hora] = $json["usuario"];
    }
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

        table,
        th,
        td {
            border: 1px solid black;
            padding: 0 1rem;
        }

        table {
            border-collapse: collapse;
            text-align: center;
        }

        th {
            background-color: #CCC;
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
    <h4>Hoy es <?php echo $dia;  ?></h4>
    <?php


    echo "<table>";
    echo "<tr>";
    echo "<th>Hora</th>";
    echo "<th>Profesor de Guardia</th>";
    echo "<th>Informacion del profesor con Id:</th>";
    echo "</tr>";

    for ($hora = 1; $hora <= count($horas); $hora++) {

        if ($hora != 4) {
            echo "<tr>";
            echo "<td>" . $horas[$hora] . "</td>";
            echo "<td>";
            echo "<ol>";
            foreach($profesores_guardia[$hora] as $tupla){
                echo "<li><button class='enlace' name='btnDetalles' value='".$tupla["id_usuario"]."'>".$tupla["nombre"]."</button></li>";
            }
            echo "</ol>";
            echo "</td>";
            echo "</tr>";
        }
    }


    echo "</table>";
    ?>

</body>

</html>