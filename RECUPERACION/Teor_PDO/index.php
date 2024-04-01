<?php
    session_name("Nombre_App1");
    session_start();


    session_destroy();//Destruye y empieza denuevo
    session_unset(); //Resetea toda las variables pero no las borra
    //SI tengo la sesion creada me he logueado y voy por x lado , si no voy por el otro lado (Utilizar esa logica para el login)
    $_SESSION["usuario"]="Un usuario";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teoria PDO</title>
</head>

<body>
    <?php
    define("SERVIDOR_BD", "localhost");
    define("USUARIO_BD", "jose");
    define("CLAVE_BD", "josefa");
    define("NOMBRE_BD", "bd_foro");

    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        die("<p>No he podido conectarse a la base de batos: " . $e->getMessage() . "</p></body></html>");
    }




    try {
        $usuario = "jenn";
        $clave = md5("123456");
        $consulta = "select * from usuarios where usuario=? and clave=?";
        $sentencia = $conexion->prepare($consulta); //Para preparar la consulta
        $sentencia->execute([$usuario, $clave]); //Ejecutar la consulta
    } catch (Exception $e) {   //Cuando muere cierro todo con null
        $sentencia = null;
        $conexion = null;
        die("<p>No se ha podido realizar la consulta: " . $e->getMessage() . "</p></body></html>");
    }


    if ($sentencia->rowCount() > 0) {
        echo "<p>He obtenido una tupla";
        $tupla = $sentencia->fetch(PDO::FETCH_ASSOC); //Para almacenar  una tabla en la variable tupla
        echo "<p>Nombre: " . $tupla["nombre"] . "</p>";
    } else {
        echo "<p>No he obtenido una tupla";
    }









    try {
        $consulta = "select * from usuarios";
        $sentencia = $conexion->prepare($consulta); //Para preparar la consulta
        $sentencia->execute(); //Ejecutar la consulta
    } catch (Exception $e) {   //Cuando muere cierro todo con null
        $sentencia = null;
        $conexion = null;
        die("<p>No se ha podido realizar la consulta: " . $e->getMessage() . "</p></body></html>");
    }


    //Primera forma de recorrer todas las tuplas
    /*
    $tuplas=$sentencia->fetchAll(PDO::FETCH_ASSOC);

    for ($i=0; $i < count($tuplas); $i++) { 
        echo "<p>Nombre: ". $$tuplas[$i]["nombre"] ."</p>";
    }


    foreach($tuplas as $tupla){
        echo "<p>Nombre: ". $tupla["nombre"] ."</p>";
    }
    */



    //Segunda forma

    while($tupla=$sentencia->fetchAll(PDO::FETCH_ASSOC)){
        echo "<p>Nombre: " . $tupla["nombre"] . "</p>";
    }










    try {
        $consulta = "insert into usuarios (nombre,usuario,clave,email) values (?,?,?,?)";
        $sentencia = $conexion->prepare($consulta);     //Para preparar la consulta
        $sentencia->execute(["Pepa pil","pepa",md5("123456"),"pepa@gmail.com"]);    //Ejecutar la consulta
    } catch (Exception $e) {   //Cuando muere cierro todo con null
        $sentencia = null;
        $conexion = null;
        die("<p>No se ha podido realizar la consulta: " . $e->getMessage() . "</p></body></html>");
    }

    echo "<p>Usuario insertado con clave autonumerica a valor".$conexion->lastInsertId(). "</p>";






    $sentencia = null;
    $conexion = null;

    echo "<p>Todo Bien</p>";
    ?>
</body>

</html>