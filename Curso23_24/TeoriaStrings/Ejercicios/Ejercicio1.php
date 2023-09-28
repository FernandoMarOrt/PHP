<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio1</title>
</head>
<body>
    <form action="recogidaFormulario.php" method="post" enctype="multipart/form-data">

        <div style="background-color:lightblue; border:solid; padding:5px;">

            <h1 style="text-align:center">Ripios - Formulario</h1>

            <p>Dime dos palabras y te dire si riman o no</p>
            <p>
                <label for="primera">Primera palabra :</label>
                <input type="text" name="primera" id="primera"><br>
            </p>
            <p>
                <label for="segunda">Segunda palabra:</label>
                <input type="text" name="segunda" id="segunda"><br>
            </p>

            <p>
                <button type="submit" name="comparar">Comparar</button>
            </p>

        </div>

        <div style="background-color:lightgreen; border:solid; margin-top:10px; padding:5px;">

            <h1 style="text-align:center">Ripios - Resultado</h1>

            <p>Dime dos palabras y te dire si riman o no</p>

        </div>
        
    </form>
</body>
</html>