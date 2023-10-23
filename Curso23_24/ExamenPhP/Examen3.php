<?php

    if(isset($_POST["contar"])){

        $error_formu=$_POST["texto"] =="";
    }

    function mi_explode($texto){

        $separador = $_POST["sep"];

        while (isset($texto[$cont])) {
            $cont++;
            if(isset($texto[$cont]) == $separador){
                $cont2++;

                if($texto[$cont+1]!=$separador){
                    $cont2+1;
                }
            }
        }

        return $cont2;
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .error{color:red;}
    </style>
</head>
<body>
    <form action="Examen3.php" method="post">
    <p>
        <label for="sep">Elija Separador</label>
        <select name="sep" id="sep">
            <option value=",">, (coma)</option>
            <option value=";">; (punto y coma)</option>
            <option value=" "> (espacio)</option>
            <option value=":">: (dos puntos)</option>
        </select>
    </p>

    <p>
        <label for="texto">Introduzca una frase</label>
        <input type="text" name="texto" id="texto" value="<?php if(isset($_POST["texto"])) echo $_POST["texto"];?>">
        <?php

            if(isset($_POST["contar"]) && $error_formu){
                echo "<span class='error'>*Escribe un texto por favor*</span>";
            }
        ?>
    </p>

    <p>
        <button type="submit" name="contar">Contar</button>
    </p>


    <?php
        if(isset($_POST["contar"]) && !$error_formu){
            echo "<p>El texto contiene: ".mi_explode($_POST["texto"])." palabras</p";
        }

    ?>

</body>
</html>