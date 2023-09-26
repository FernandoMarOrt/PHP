<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio9</title>
</head>
<body>

    <?php

        $lenguajes_cliente['M65D']='Madrid';
        $lenguajes_cliente['B23C']='Barcelona';
        $lenguajes_cliente['L61D']='Londres';

        $lenguajes_servidor['N89Y']='New York';
        $lenguajes_servidor['L37A']='Los Angeles';
        $lenguajes_servidor['C92G']='Chicago';


        foreach ($arr as $indice => $valores) {
            echo "<p>La ciudad con el indice ".$indice." tiene el nombre de: ".$valores."</p>";
        }

    ?>
    
</body>
</html>