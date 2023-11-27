<?php
define("SERVIDOR_BD", "localhost");
define("USUARIO_BD", "jose");
define("CLAVE_BD", "josefa");
define("NOMBRE_BD", "bd_exam_colegio");


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Notas de los alumnos</h1>
    <?php
    if (!isset($conexion)) {
        try {
            $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
            mysqli_set_charset($conexion, "utf8");
        } catch (Exception $e) {
            die("<p>No ha podido conectarse a la base de batos: " . $e->getMessage() . "</p></body></html>");
        }
    }
    try {
        $consulta = "select * from alumnos";
        $resultado = mysqli_query($conexion, $consulta);
    } catch (Exception $e) {
        mysqli_close($conexion);
        die("<p>No se ha podido realizar la consulta: " . $e->getMessage() . "</p></body></html>");
    }

    if (mysqli_fetch_assoc($resultado) > 0) {
        mysqli_data_seek($resultado, 0);

        echo "<form action='index.php' method='post'>";
        echo "<label>Seleccione un alumno:</label> <select name='alumno' id='alumno'>";

        while ($tupla = mysqli_fetch_assoc($resultado)) {

            if (isset($_POST["alumno"]) && $_POST["alumno"] == $tupla["cod_alu"]) {
                echo "<option selected value='" . $tupla["cod_alu"] . "'>" . $tupla["nombre"] . "</option>";
                $nombre_alumno = $tupla["nombre"];
            } else {
                echo "<option value='" . $tupla["cod_alu"] . "'>" . $tupla["nombre"] . "</option>";
            }
        }

        echo "</select>";
        echo " <button type='submit' name='btnVernotas'>Ver notas</button>";
        echo "</form>";

        if (isset($_POST["btnVernotas"])) {
            echo "<h2>Notas del alumno: " . $nombre_alumno . "</h2>";
            mysqli_data_seek($resultado, 0);

            try {
                $consulta = "select * from notas";
                $resultado = mysqli_query($conexion, $consulta);
            } catch (Exception $e) {
                mysqli_close($conexion);
                die("<p>No se ha podido realizar la consulta: " . $e->getMessage() . "</p></body></html>");
            }



            echo "<table>";
            echo "<tr><th>Asignatura</th><th>Nota</th><th>Accion</th></tr>";
            while ($tupla2 = mysqli_fetch_assoc($resultado)) {
                echo "<tr>";
                echo "<td>".$tupla2["denominacion"]."</td>";
                echo "<td>" .$tupla2["nota"]."</td>";
                echo "</tr>";
            }
            echo "</table>";
        }

        //














    } else {
        echo "En estos momentos no tenemos ningun alumno registrado en la BD";
    }


    mysqli_free_result($resultado);
    mysqli_close($conexion);
    ?>
</body>

</html>