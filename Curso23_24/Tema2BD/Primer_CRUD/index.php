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
        .enlace{
            border:none;
            background: none;
            cursor: pointer;
            color:blue;
            text-decoration: underline;
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
            echo "<td><form action='index.php' method='post'><button class='enlace' type='submit' value='".$tupla["id_usuario"]."' name='btnDetalle'>".$tupla["nombre"]."</button></form></td>";
            echo "<td><form action='index.php' method='post'><button type='submit' value='".$tupla["id_usuario"]."' name='btnBorrar'><img src='images/x.png' alt='Imagen de Borrar' title='Imagen de Borrar'</button></form></td>";
            echo "<td><form action='index.php' method='post'><button type='submit' value='".$tupla["id_usuario"]."' name='btnEditar'><img src='images/lapiz.png' alt='Imagen de Editar' title='Imagen de Editar'</button></form></td>";
            echo "</tr>";
        }

        echo "</table>";

        //PARA SUSTITUIR EL BOTON SI PULSAS ALGUNO DE LOS NOMBRES Y CONSULTAR LOS DATOS DE UN USUARIO
        if(isset($_POST["btnDetalle"])){

            echo "<h3> Detalles del usuario con id: ".$_POST["btnDetalle"]."</h3>";

            try {

                $consulta="select * from usuarios where id_usuario='".$_POST["btnDetalle"]."'";
                $resultado=mysqli_query($conexion,$consulta);
                
            } catch (Exception $e) {
        
                mysqli_close($conexion);
                die("<p>No se ha podido realizar la consulta: ".$e->getMessage()."</p></body></html>");
                
            }

            //ES BASICAMENTE $tupla con otro nombre
            if(mysqli_num_rows($resultado)>0){

                $datos_usuario=mysqli_fetch_assoc($resultado);

                echo "<p>";
                echo "<strong>Nombre: </strong>".$datos_usuario["nombre"]."</br>";
                echo "<strong>Usuario: </strong>".$datos_usuario["usuario"]."</br>";
                echo "<strong>Email: </strong>".$datos_usuario["email"]."</br>";
                echo "</p>";
            }else{

                echo "<p>El usuario selecciona ya no se encuentra registrado en la BD";

            }

 
            echo "<form action='index.php' method='post'>";
            echo "<p><button type='submit'>Volver</button></p>";
            echo "</form>";

        }elseif(isset($_POST["btnBorrar"])){


            
        }elseif(isset($_POST["btnBorrar"])){


        }else{
            echo "<form action='usuario_nuevo.php' method='post'>";
            echo "<p><button type='submit' name='btnNuevoUsuario'>Insertar nuevo usuario</button></p>";
            echo "</form>";

        }
 
        mysqli_free_result($resultado); //LIBERO LA CONSULTA
        mysqli_close($conexion);

       
    ?>
    
</body>
</html>