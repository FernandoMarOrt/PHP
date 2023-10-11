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

        $mes[1]="Enero";
        $mes[2]="Febrero";
        $mes[3]="Marzo";
        $mes[4]="Abril";
        $mes[5]="Mayo";
        $mes[6]="Junio";
        $mes[7]="Julio";
        $mes[8]="Agosto";
        $mes[9]="Septiembre";
        $mes[10]="Octubre";
        $mes[11]="Noviembre";
        $mes[12]="Diciembre";
    ?>



    <form action="fechas2.php" method="post" enctype="multipart/form-data">

        <div style="background-color:lightblue; border:solid; padding:5px;">

            <h1 style="text-align:center">Fechas - Formulario</h1>

            <p>
                <label>Introduzca una fecha:</label>
            </p>

            <p>
                <label for="dia1">Dia:</label>
                <select name="dias1" id="dias1">

                    <?php
                        for ($i=1; $i <= 31; $i++) { 
                            echo "<option value=".$i.">".$i."</option>";
                        }

                    ?>
                    
                </select>

                <label for="mes1">Mes:</label>

                <select name="meses1" id="meses1">

                    <?php
                        for ($i=1; $i<count($mes); $i++) { 
                            echo "<option value=".$i.">".$mes[$i]."</option>";
                        }

                    ?>

                </select>
                <label for="año1">Año:</label>
                <select name="años1" id="años1">

                    <?php
                        for ($i=date("Y"); $i >= (date("Y")-50); $i--) { 
                            echo "<option value=".$i.">".$i."</option>";
                        }

                    ?>

                </select>
            </p>



            <p>
                <label>Introduzca una fecha:</label>
            </p>

            <p>
                <label for="dia2">Dia:</label>
                <select name="dias2" id="dias2">

                    <?php
                        for ($i=1; $i <= 31; $i++) { 
                            echo "<option value=".$i.">".$i."</option>";
                        }

                    ?>
                    
                </select>

                <label for="mes2">Mes:</label>

                <select name="meses2" id="meses2">

                    <?php
                        for ($i=1; $i<count($mes); $i++) { 
                            echo "<option value=".$i.">".$mes[$i]."</option>";
                        }

                    ?>

                </select>
                <label for="año2">Año:</label>
                <select name="años2" id="años2">

                    <?php
                        for ($i=date("Y"); $i >= (date("Y")-50); $i--) { 
                            echo "<option value=".$i.">".$i."</option>";
                        }

                    ?>

                </select>
            </p>
        
           

            <p>
                <button type="submit" name="calcular">Calcular</button>
            </p>

        </div>


        <?php

            if (isset($_POST["calcular"])) {

                echo'<div style="background-color:lightgreen; border:solid; margin-top:10px; padding:5px;">';

                    echo'<h1 style="text-align:center">Fechas - Respuesta</h1>';

                    $tiempo1=mktime(0,0,0,$_POST["dias1"],$_POST["meses1"],$_POST["años1"]);
                    $tiempo2=mktime(0,0,0,$_POST["dias2"],$_POST["meses2"],$_POST["años2"]);

                    $dif_segundos=abs($tiempo1-$tiempo2);
                    $dias_pasados=floor($dif_segundos/(60*60*24));


                    echo "<p>La diferencia de las 2 fechas introducidas es de ".$dias_pasados." dias</p>";

                echo'</div>';
                
                
            }

        ?>
  
    </form>
</body>
</html>