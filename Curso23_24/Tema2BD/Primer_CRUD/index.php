<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=ç, initial-scale=1.0">
    <title>Practica 1º CRUD</title>
    <style>
        table,th,td {
            border:1px solid black;
        }
        table{
            border-collapse: collapse; 
            width: 30%; 
            text-align: center;
        }
        th{
            background-color: #CCC;
        }
        table img{
            width: 50px;
            height: 50px;
        }
    </style>
</head>
<body>
    <h1>Listado de los usuarios</h1>
    <?php

        try{
            
            $conexion=mysqli_connect("localhost","jose","josefa","bd_foro");
            mysqli_set_charset($conexion,"utf8");

        }catch(Exception $e){

            die("<p>No ha podido conectarse a la base de datos: ".$e->getMessage()."</p></body></html>");
        }

        $consulta="select * from usuarios";


        try {

            $resultado=mysqli_query($conexion,$consulta);
            
        } catch (Exception $e) {
    
            mysqli_close($conexion);
            die("<p>Imposible realizar la consulta: ".$e->getMessage()."</p></body></html>");
            
        }
        

        //if(mysqli_num_rows($resultado) > 1){}     Condiciona si la tabla esta vacia o no
        
        echo "<table>";

        echo "<tr><th>Nombre de usuario</th><th>Borrar</th><th>Editar</th></tr>";
        while ($tupla=mysqli_fetch_assoc($resultado)) {
            
            echo "<tr>";
            echo "<td>".$tupla["nombre"]."</td>";
            echo "<td><img src='images/x.png' alt='Imagen de Borrar' title='Imagen de Borrar'</td>";
            echo "<td><img src='images/lapiz.png' alt='Imagen de Editar' title='Imagen de Editar'</td>";
            echo "</tr>";
        }

        echo "</table>";

        echo "<form action='usuario_nuevo.php' method='post'>";
        echo "<p><button type='submit' name='btnNuevoUsuario'>Insertar nuevo usuario</button></p>";
        echo "</form>";

        mysqli_free_result($resultado); //LIBERO LA CONSULTA
        mysqli_close($conexion);
    ?>
    
</body>
</html>