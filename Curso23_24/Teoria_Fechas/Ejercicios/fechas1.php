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

            function limpiarFecha ($fecha){

                $fechalimpia = trim(fecha)

            }

            //Si los campos estan vacios o no contienen la longitud adecuada
            if (isset($_POST["calcular"])) {

                
                $errorFecha1 = $_POST["fecha1"] == "" || strlen(trim($_POST["primera"])) <3;

                

                $errorFecha2 = $_POST["fecha2"] == "" || strlen(trim($_POST["segunda"])) < 3;

                $errorFormu = $errorFecha1 || $errorFecha2;
            }


           
        ?>


    <form action="Ejercicio1.php" method="post" enctype="multipart/form-data">

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

                    if(substr(strtolower($_POST['primera']),-3) == substr(strtolower($_POST['segunda']),-3)){

                        echo '<p>'.$_POST['primera'].' y '.$_POST['segunda'].' riman</p>';

                    }elseif(substr(strtolower($_POST['primera']),-3) == substr(strtolower($_POST['segunda']),-2)){
                        
                        echo '<p>'.$_POST['primera'].' y '.$_POST['segunda'].' riman un poco</p>';

                    }else {

                        echo '<p>'.$_POST['primera'].' y '.$_POST['segunda'].' no riman</p>';
                    }

                echo'</div>';
                
                
            }

        ?>

        

        
        
    </form>
</body>
</html>