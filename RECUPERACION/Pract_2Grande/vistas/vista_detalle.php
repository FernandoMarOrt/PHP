<?php
 echo "<div class='centrar'>";
 echo "<h3>Detalles del usuario con id:".$_POST["btnDetalles"]."</h3>";
 if($detalles_usu)
 {
     echo "<p><strong>Nombre: </strong>".$detalles_usu["nombre"]."</p>";
     echo "<p><strong>Usuario: </strong>".$detalles_usu["usuario"]."</p>";
     echo "<p><strong>Contraseña: </strong>*********</p>";
     echo "<p><strong>DNI: </strong>".$detalles_usu["dni"]."</p>";
     echo "<p><strong>Foto: </strong><img class='reducida' src='images/".$detalles_usu["foto"]."' alt='Foto' title='Foto'/></p>";
 }
 else
     echo "<p>El usuario seleccionado ya no se encuentra en la BD</p>";
 echo "</div>";
?>