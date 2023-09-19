<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Practica1</title>
</head>
<body>
    <form action="recogida.php" method="post">
  
    
    <label for="nombre">Nombre:</label>
    <input type="text" id="Nombre" name="Nombre" /></br></br>

    <label for="apellidos">Apellidos:</label>
    <input type="text" id="apellidos" name="Apellidos" /></br></br>

    <label for="contraseña">Contraseña:</label>
    <input type="text" id="contraseña" name="Contraseña" /></br></br>

    <label for="dni">DNI:</label>
    <input type="text" id="dni" name="DNI" /></br></br>
    

    <label for="dni">Sexo:</label><br>

    <input type="radio" id="Hombre" name="sexo" value="Hombre">
    <label for="Hombre">Hombre</label><br>

    <input type="radio" id="Mujer" name="sexo" value="Mujer">
    <label for="Mujer">Mujer</label><br>
    
    <label for="Nacido">Nacido:</label>
    <select id="Nacido" name="Nacido" size="1" multiple>
        <option value="Malaga">Malaga</option>
        <option value="Sevilla">Sevilla</option>
        <option value="Jaen">Jaen</option>
    </select><br><br>

    <label for="msg">Comentarios:</label>
    <textarea id="comentarios" name="Comentarios"></textarea></br></br>



    <input type="checkbox" name="Suscribirse" checked>Suscribirse al boletin de Novedades</br></br>



    <input type="submit" value="Guardar Cambios">
    <input type="reset" value="Borrar los datos introducidos">
    
<   /form>

</body>
</html>