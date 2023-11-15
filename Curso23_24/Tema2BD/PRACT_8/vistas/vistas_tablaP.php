<?php
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

echo "<table>";
echo "<tr><th>#</th><th>Foto</th><th>Nombre</th><th><form action='index.php' method='post'><button class='enlace' type='submit' name='btnNuevoUsuario'>Usuario+</button></th></tr>";
while ($tupla = mysqli_fetch_assoc($resultado)) {
    echo "<tr>";
    echo "<td>" . $tupla["id_usuario"] . "</<td>";
    echo "<td><img src='img/" . $tupla["foto"] . "' alt='Foto de perfil' title=''Foto de perfil</td>";
    echo "<td><form action='index.php' method='post'><button class='enlace' type='submit' value='" . $tupla["id_usuario"] . "' name='btnDetalle' title='Detalles del Usuario'>" . $tupla["nombre"] . "</button></form></td>";
    echo "<td><form action='index.php' method='post'><input type='hidden' name='nombre_foto' value='" . $tupla["foto"] . "'><button class='enlace' type='submit' value='" . $tupla["id_usuario"] . "' name='btnBorrar'>Borrar</button> - <button class='enlace' type='submit' value='" . $tupla["id_usuario"] . "' name='btnEditar'>Editar</button></form></td>";
    echo "</tr>";
}
echo "</table>";
mysqli_free_result($resultado);
?>