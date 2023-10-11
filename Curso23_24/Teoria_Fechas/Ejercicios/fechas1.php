<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio1</title>
    <style>.error{color:red;}</style>
</head>
<body>

        <?php

            /*function barrasBien($fecha){ ASI TAMBIEN SE PUEDE HACER LO DE BUENOS SEPARADORES DPS HAY QUE NEGARLO EN PLAN !barrasBien

                if($fecha[2] == "/" && $fecha[5] == "/"){
                    return true;
                }else{
                    return false;
                }

            }*/ 

            
            
            //Si los campos estan vacios o no contienen la longitud adecuada
            if (isset($_POST["calcular"])) {

                $buenos_separadores = substr($_POST["fecha1"],2,1)=="/" && substr($_POST["fecha1"],5,1)=="/";

                $array_numeros1 = explode("/",$_POST["fecha1"]); //Divido la fecha con separadores "/" y hago un array con ella

                $numeros_buenos1 = is_numeric($array_numeros1[0]) &&  is_numeric($array_numeros1[1]) &&  is_numeric($array_numeros1[2]);

                $fecha_valida1 = checkdate($array_numeros1[1],$array_numeros1[0],$array_numeros1[2]);


                $buenos_separadores2 = substr($_POST["fecha2"],2,1)=="/" && substr($_POST["fecha2"],5,1)=="/";
                
                $array_numeros2 = explode("/",$_POST["fecha2"]); //Divido la fecha con separadores "/" y hago un array con ella

                $numeros_buenos2 = is_numeric($array_numeros2[0]) &&  is_numeric($array_numeros2[1]) &&  is_numeric($array_numeros2[2]);

                $fecha_valida2 = checkdate($array_numeros2[1],$array_numeros2[0],$array_numeros2[2]);



                
                $errorFecha1 = $_POST["fecha1"] == "" || !$buenos_separadores || strlen($_POST["fech1"])!=10 || !$numeros_buenos1 || !$fecha_valida;

                $errorFecha2 = $_POST["fecha2"] == "" || !barrasBien($_POST["fecha2"]);

                $errorFormu = $errorFecha1 || $errorFecha2;
            }


           
        ?>


    <form action="fechas1.php" method="post" enctype="multipart/form-data">

        <div style="background-color:lightblue; border:solid; padding:5px;">

            <h1 style="text-align:center">Fechas - Formulario</h1>

            <p>
                <label for="fecha1">Introduzca una fecha: (DD//MM/YYYY)</label>
                <input type="text" name="fecha1" id="fecha1" value="<?php if(isset($_POST['fecha1'])) echo $_POST['fecha1']?>"/>
                <?php
                    if (isset($_POST["calcular"]) && $errorFecha1) {
                        echo "<span class='error'>*Introduce una palabra de al menos 3 letras*</span>";
                    }
                ?>
            </p>
            <p>
            <label for="fecha2">Introduzca una fecha: (DD//MM/YYYY)</label>
                <input type="text" name="fecha2" id="fecha2" value="<?php if(isset($_POST['fecha2'])) echo $_POST['fecha2']?>"/>
                <?php
                    if (isset($_POST["calcular"]) && $errorFecha2) {
                        echo "<span class='error'>*Introduce una palabra de al menos 3 letras*</span>";
                    }
                ?>
                
            </p>

            <p>
                <button type="submit" name="calcular">Calcular</button>
            </p>

        </div>


        <?php

            if (isset($_POST["calcular"]) && !$errorFormu) {

                echo'<div style="background-color:lightgreen; border:solid; margin-top:10px; padding:5px;">';

                    echo'<h1 style="text-align:center">Fechas - Respuesta</h1>';

                    $flechinda = $_POST["fecha1"];

                    echo "<p>".$flechinda[2]."</p>";

                echo'</div>';
                
                
            }

        ?>

        

        
        
    </form>
</body>
</html>