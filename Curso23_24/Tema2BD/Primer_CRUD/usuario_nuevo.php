<?php

    if(isset($_POST["btnNuevoUsuario"]) || isset($_POST["continuar"])){

        if(isset($_POST["continuar"])){
            $error_nombre=$_POST["nombre"]=="";
            $error_usuario=$_POST["usuario"]=="";
            $error_clave=$_POST["clave"]=="";
            $error_email=$_POST["email"]== "" || !filter_var($_POST["email"],FILTER_VALIDATE_EMAIL);
            $error_form= $error_nombre || $error_usuario ||  $error_clave || $error_email; 
            if(!$error_form){
                
            }
        }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Nuevo Usuario</h1>
    <form action="usuario_nuevo.php" method="post" enctype="multipart/form-data">
        <p>
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" maxlength="30" value="">
        </p>

        <p>
            <label for="usuario">Usuario:</label>
            <input type="text" name="usuario" id="usuario" maxlength="20" value="">
        </p>

        <p>
            <label for="clave">Contraseña:</label>
            <input type="password" name="clave" maxlength="15" id="clave">
        </p>

        <p>
            <label for="email">Email:</label>
            <input type="text" name="email" id="email" maxlength="50" value="">
        </p>

        <p>
            <button type="submit" name="continuar">Continuar</button>
            <button type="submit" name="volver">Volver</button>
        </p>
    </form>
</body>
</html>
<?php

}else{
    header("Location:index.php");
    exit;
}
?>