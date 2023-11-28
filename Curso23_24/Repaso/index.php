<?php
 require "src/funciones.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Repaso</h1>
    <?php




        if(!isset($conexion)){
            try {
                mysqli_connect("SERVIDOR_BD","USUARIO_BD","CLAVE_BD","NOMBRE_BD");
                mysqli_set_charset($conexion,"utf8");
                
            } catch (Exception $e) {
                die("<p>Error al realizar la conexion con la bd".$e->getMessage()."</p></body></html>");
            }
        }



        try {
            $consulta= "select * from usuarios";
            $resultado= mysqli_query($conexion,$consulta);
            
        } catch (Exception $e) {
            die("<p>Error al realizar la conexion con la bd".$e->getMessage()."</p></body></html>");
        }















        echo "<h2>Tabla con los datos de los usuario</h2>";
        echo "<table>";
        echo "<tr><th>Dato1</th><th>Dato2</th><th>Dato3</th><th>Dato4</th></tr>";
        while ($tupla=mysqli_fetch_assoc($resultado)) {
            echo "<tr>";
            echo "<td>".$tupla["nombre"]."</td>";
            echo "<td>".$tupla["nombre"]."</td>";
            echo "<td>".$tupla["nombre"]."</td>";
            echo "<td><img src='Img/".$tupla["foto"]."' name='foto' alt='foto de prueba'></td>";
            echo "<td><form action='index.php' method='post'><button> type='submit' name='btnEditar' value='".$tupla["id_usuario"]."'>".$tupla["nombre"]."</button></form></td>";
            echo "<td><form action='index.php' method='post'><input type='hidden' name='nombre_foto' value='".$tupla["foto"]."'>
            <button class='enlace' type='submit' value='".$tupla["id_usuario"]."' name='btnBorrar'>Borrar</button> - 
            <button class='enlace' type='submit' value='".$tupla["id_usuario"]."' name='btnEditar'>Editar</button>
            </form></td>";
            echo "</tr>";
        }
        echo "</table>";
        mysqli_free_result($resultado);
        mysqli_close($conexion);


        if(!isset($conexion)){ //Inicio de la consulta
            try {
                mysqli_connect("SERVIDOR_BD","USUARIO_BD","CLAVE_BD","NOMBRE_BD");
                mysqli_set_charset($conexion,"utf8");
            } catch (Exception $e) {
                die("<p>Ha surgido un error con la bd".$e->getMessage()."</p></body></html>");
            }
        }

        try {
            $consulta = "select * from usuarios";
            $resultado = mysqli_query($conexion,$consulta);
        } catch (Exception $e) {
            die("<p>Ha surgido un error con la bd".$e->getMessage()."</p></body></html>");
        }
    ?>



           

</body>
</html>