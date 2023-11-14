<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table,
        td,
        th {
            border: 1px solid black
        }

        table {
            border-collapse: collapse;
            text-align: center
        }

        th {
            background-color: #CCC
        }

        table img {
            width: 50px;
        }

        .enlace {
            border: none;
            background: none;
            cursor: pointer;
            color: blue;
            text-decoration: underline
        }

        .error {
            color: red
        }
    </style>
</head>

<body>
    <?php
    define("SERVIDOR_BD", "localhost");
    define("USUARIO_BD", "jose");
    define("CLAVE_BD", "josefa");
    define("NOMBRE_BD", "bd_cv");


    if (!isset($conexion)) {
        try {
            $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
            mysqli_set_charset($conexion, "utf8");
        } catch (Exception $e) {
            die("<p>No ha podido conectarse a la base de batos: " . $e->getMessage() . "</p></body></html>");
        }
    }

    try {
        $consulta = "select * from usuarios";
        $resultado = mysqli_query($conexion, $consulta);
    } catch (Exception $e) {
        mysqli_close($conexion);
        die("<p>No se ha podido realizar la consulta: " . $e->getMessage() . "</p></body></html>");
    }


    if(isset($_POST["btnNuevoUsuario"])){

    ?>
        <h1>Agregar Nuevo Usuario</h1>
        <form action="index.php" method="post">
        <p>
            <label for="nombre">Nombre: </label><br/>
            <input type="text" name="nombre" id="nombre" maxlength="30" placeholder="Nombre..." value="<?php  if(isset($_POST["nombre"])) echo $_POST["nombre"];?>">
            <?php
            if(isset($_POST["btnContInsertar"]) && $error_nombre)
            {
                if($_POST["nombre"]=="")
                    echo "<span class='error'> Campo vacío</span>";
                else
                    echo "<span class='error'> Has tecleado más de 30 caracteres</span>";
            }
            ?>
        </p>
        <p>
            <label for="usuario">Usuario: </label><br/>
            <input type="text" name="usuario" id="usuario" maxlength="20" placeholder="Usuario..." value="<?php  if(isset($_POST["usuario"])) echo $_POST["usuario"];?>" >
            <?php
            if(isset($_POST["btnContInsertar"]) && $error_usuario)
            {
                if($_POST["usuario"]=="")
                    echo "<span class='error'> Campo vacío</span>";
                elseif(strlen($_POST["usuario"])>20)
                    echo "<span class='error'> Has tecleado más de 20 caracteres</span>";
                else
                    echo "<span class='error'> Usuario repetido</span>";
            }
            ?>
        </p>
        <p>
            <label for="clave">Contraseña: </label><br/>
            <input type="password" name="clave" maxlength="15" placeholder="Contraseña..." id="clave" >
            <?php
            if(isset($_POST["btnContInsertar"]) && $error_clave)
            {
                if($_POST["clave"]=="")
                    echo "<span class='error'> Campo vacío</span>";
                else
                    echo "<span class='error'> Has tecleado más de 15 caracteres</span>";
            }
            ?>
        </p>
        <p>
            <label for="DNI">DNI: </label><br/>
            <input type="text" name="DNI" id="DNI" maxlength="50" placeholder="DNI. 11223344Z" value="<?php  if(isset($_POST["DNI"])) echo $_POST["DNI"];?>">
        
        </p>
        <p>
            <button type="submit" name="btnContInsertar">Guardar Cambios</button> 
            <button type="submit">Atras</button> 
        </p>
    </form>

    <?php
        
    }

    echo "<table>";
    echo "<tr><th>#</th><th>Foto</th><th>Nombre</th><th><form action='index.php' method='post'><button class='enlace' type='submit' name='btnNuevoUsuario'>Usuario+</button></th></tr>";
    while ($tupla = mysqli_fetch_assoc($resultado)) {
        echo "<tr>";
        echo "<td>" . $tupla["id_usuario"] . "</<td>";
        echo "<td>" . $tupla["foto"] . "</td>";
        echo "<td><form action='index.php' method='post'><button class='enlace' type='submit' value='" . $tupla["id_usuario"] . "' name='btnDetalle' title='Detalles del Usuario'>" . $tupla["nombre"] . "</button></form></td>";
        echo "<td><form action='index.php' method='post'><input type='hidden' name='nombre_usuario' value='" . $tupla["nombre"] . "'><button class='enlace' type='submit' value='" . $tupla["id_usuario"] . "' name='btnBorrar'>Borrar</button> - <button class='enlace' type='submit' value='" . $tupla["id_usuario"] . "' name='btnEditar'>Editar</button></form></td>";
        echo "</tr>";
    }
    echo "</table>";
    mysqli_free_result($resultado);


  
    ?>
</body>

</html>