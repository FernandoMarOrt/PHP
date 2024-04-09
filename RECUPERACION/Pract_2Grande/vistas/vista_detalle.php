<?php
echo "<h3>Detalles del usuario con id: " . $_POST["btnDetalle"] . "</h3>";

try {

    $consulta = "select * from usuarios where id_usuario=?";
    $sentencia = $conexion->prepare($consulta);
    $sentencia->execute([$_POST["btnDetalle"]]);
} catch (PDOException $e) {
    $sentencia = null;
    $conexion = null;
    session_destroy();
    die("<p>No se ha podido realizar la consulta: " . $e->getMessage() . "</p></body></html>");
}


$datos_usuario = $sentencia->fetch(PDO::FETCH_ASSOC);
$sentencia = null;

echo "<p>";
echo "<strong>Nombre: </strong>" . $datos_usuario["nombre"] . "<br>";
echo "<strong>Usuario: </strong>" . $datos_usuario["usuario"] . "<br>";
echo "<strong>DNI: </strong>" . $datos_usuario["dni"] . "<br>";
echo "<strong>Sexo: </strong>" . $datos_usuario["sexo"] . "<br>";
echo "<strong>Subscripcion: </strong>" . $datos_usuario["subscripcion"] . "<br>";
echo "<strong>Foto:<br> </strong><img src='images/" . $datos_usuario["foto"] . "'><br>";
echo "</p>";




echo "<form action='index.php' method='post'>";
echo "<p><button type='submit'>Volver</button></p>";
echo "</form>";
