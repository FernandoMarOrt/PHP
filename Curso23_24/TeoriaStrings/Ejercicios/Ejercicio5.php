<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio4</title>
    <style>.error{color:red;}</style>
</head>
<body>

        <?php

            const VALOR = array("M" => 1000,"D" => 500,"C" => 100,"L" => 50,"X" => 10,"V" => 5,"I" => 10);           

            function letras_bien($texto){
                $bien = true;

                for ($i=0; $i < strlen($texto); $i++) { 
                    if(!isset(VALOR[$texto[$i]])){
                        $bien=false;
                        break;
                    }
                }
                return $bien;
            }

            function orden_bueno($texto){

                $bien = true;

                for ($i=0; $i < strlen($texto)-1; $i++) { 
                    if(VALOR[$texto[$i]]<VALOR[$texto[$i+1]]){
                        $bien=false;
                        break;
                    }
                }
                return $bien;

            }

            function repite_bien($texto){

                $veces["I"]=4;
                $veces["V"]=1;
                $veces["X"]=4;
                $veces["L"]=1;
                $veces["C"]=4;
                $veces["D"]=1;
                $veces["M"]=4;

                $bien = true;

                for ($i=0; $i < strlen($texto); $i++) { 

                    $veces[$texto[$i]]--;
                    if($veces[$texto[$i]]==-1){
                        $bien=false;
                        break;
                    }
                }

                return $bien;

            }


            //Si los campos estan vacios o no contienen la longitud adecuada
            if (isset($_POST["comparar"])) {


                $texto=trim($_POST['primera']);
                $errorPrimera = $_POST["primera"] == "" || !is_numeric($texto) || $texto <= 0 || $texto >= 5000;


                $errorFormu = $errorPrimera;
            }


           
        ?>


    <form action="Ejercicio4.php" method="post" enctype="multipart/form-data">

        <div style="background-color:lightblue; border:solid; padding:5px;">

            <h1 style="text-align:center">Arabes a romanos - Formulario</h1>

            <p>Dime un numero en numeros arabes y lo convertire en Romanos</p>
            <p>
                <label for="primera">Numero:</label>
                <input type="text" name="primera" id="primera" value="<?php if(isset($_POST['primera'])) echo trim($_POST['primera'])?>"/>
                <?php
                    if (isset($_POST["comparar"]) && $errorFormu) {

                        if($_POST["primera"]==''){
                            echo "<span class='error'>*Campo vacio*</span>";
                        }else {
                            echo "<span class='error'>*No has escrito un numero romano correcto*</span>";
                        }
                        
                    }
                ?>
            </p>

            <p>
                <button type="submit" name="comparar">Convertir</button>
            </p>

        </div>


        <?php

            if (isset($_POST["comparar"]) && !$errorFormu) {

                $res="";
                $num=$texto;
                while ($num > 0) {
                    switch ($num) {
                        case 'value':
                            # code...
                            break;
                        
                        default:
                            # code...
                            break;
                    }
                }
                echo'<div style="background-color:lightgreen; border:solid; margin-top:10px; padding:5px;">';

                    echo'<h1 style="text-align:center">Arabes a romanos  - Resultado</h1>';

                    echo '<p> El numero '.$texto_m.' se escribe en cifras arabes: '.$res.'</p>';


                echo'</div>';
                
                
            }

        ?>

        

        
        
    </form>
</body>
</html>