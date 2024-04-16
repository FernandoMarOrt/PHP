<?php
if (isset($_POST["btnEditar"]))
    $idUsuario = $_POST["btnEditar"];
else
    $idUsuario = $_POST["id_usuario"];



try {
    $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
} catch (PDOException $e) {
    session_destroy();
    die(error_page("Práctica Rec 2", "<h1>Práctica Rec 2</h1><p>Imposible conectar a la BD. Error:" . $e->getMessage() . "</p>"));
}

try {
    $consulta = "select * from usuarios where id_usuario='" . $idUsuario . "'";
    $sentencia = $conexion->prepare($consulta);
    $sentencia->execute();
} catch (PDOException $e) {

    $setencia = null;
    $conexion = null;
    session_destroy();
    die(error_page("Práctica Rec 2", "<h1>Práctica Rec 2</h1><p>Imposible realizar la consulta. Error:" . $e->getMessage() . "</p>"));
}

if ($sentencia->rowCount() > 0) {

    

    if (isset($_POST["btnEditar"])) {
        $datos_usu = $sentencia->fetch(PDO::FETCH_ASSOC);
        $setencia = null;

        $usuario = $datos_usu["usuario"];
        $clave = $datos_usu["clave"];
        $nombre = $datos_usu["nombre"];
        $dni = $datos_usu["dni"];
        $sexo = $datos_usu["sexo"];
        $subscripcion = $datos_usu["subscripcion"];

    }else{


        $usuario = $_POST["usuario"];
        $clave = $_POST["clave"];
        $nombre = $_POST["nombre"];
        $dni = $_POST["dni"];
        $sexo = $_POST["sexo"];
        $subscripcion = $_POST["subscripcion"];

    }
} else {
    $error_existencia = "<p>El usuario seleccionado ya no se encuentra en la BD</p>";
}

if (isset($error_existencia)) {
    echo "<h2>Editando el usuario con id " . $idUsuario . "</h2>";
    echo $error_existencia;
    echo "<form action='index.php' method='post'>";
    echo "<p><button type='submit'>Volver</button></p>";
    echo "</form>";
} else {
    ?>

<form action="index.php" method="post" enctype="multipart/form-data">
        <p>
            <label for="usuario">Usuario: </label><br>
            <input type="text" id="usuario" name="usuario" value="<?php echo $usuario;?>" placeholder="Usuario...">
            <?php
            if(isset($_POST["btnEnviar"])&& $error_usuario)
            {
                if($_POST["usuario"]=="")
                    echo "<span class='error'> Campo vacío</span>";
                else
                    echo "<span class='error'> Usuario repetido</span>";
            }
                
            ?>
        </p>
        <p>
            <label for="nombre">Nombre: </label><br>
            <input type="text" id="nombre" name="nombre" value="<?php echo $nombre;?>" placeholder="Nombre...">
            <?php
            if(isset($_POST["btnEnviar"])&& $error_nombre)
                echo "<span class='error'> Campo vacío</span>";
            ?>
        </p>
        <p>
            <label for="clave">Contraseña: </label><br>
            <input type="password" id="clave" name="clave" placeholder="Contraseña...">
            <?php
            if(isset($_POST["btnEnviar"])&& $error_clave)
                echo "<span class='error'> Campo vacío</span>";
            ?>
        </p>
        <p>
            <label for="dni">DNI: </label><br>
            <input type="text" id="dni" name="dni" value="<?php echo $dni;?>" placeholder="DNI: 11223344Z">
            <?php
            if(isset($_POST["btnEnviar"])&& $error_dni)
            {
                if($_POST["dni"]=="")
                    echo "<span class='error'> Campo vacío</span>";
                else if(!dni_bien_escrito($_POST["dni"]))
                    echo "<span class='error'> DNI no está bien escrito</span>";
                else if(!dni_valido($_POST["dni"]))
                    echo "<span class='error'> DNI no es válido</span>";
                else
                    echo "<span class='error'> DNI repetido</span>";
            }
            ?>
        </p>
        <p>
            <label>Sexo: </label><br>
            <input type="radio" id="hombre" name="sexo" value="hombre" <?php if($sexo == "hombre") echo "checked";?>>
            <label for="hombre">Hombre: </label><br>
            <input type="radio" id="mujer" name="sexo" value="mujer" <?php if($sexo == "mujer") echo "checked";?>>
            <label for="mujer">Mujer: </label><br>
        </p>
        <p>
            <label for="foto">Incluir mi foto (Máx. 500 KB)</label>
            <input type="file" name="foto" id="foto" accept="image/*">
            <?php
            if(isset($_POST["btnEnviar"])&& $error_foto)
            {
                if($_FILES["foto"]["error"])
                    echo "<span class='error'> Error en la subida del fichero al servidor </span>";
                else if (!explode(".",$_FILES["foto"]["name"]))
                    echo "<span class='error'> El fichero subido debe tener extensión </span>";
                else if (! getimagesize($_FILES["foto"]["tmp_name"]))
                    echo "<span class='error'> El fichero subido debe ser una imagen</span>";
                else
                    echo "<span class='error'> El tamaño del fichero no debe superar los 500 KB</span>";
            }
            ?>
        </p>
        <p>
            <input type="checkbox" id="subsc" name="subscripcion" <?php if($subscripcion == 1) echo "checked"?>>
            <label for="subsc">Suscribirme al boletín de novedades: </label><br>
        </p>
        <p>
                <input type="hidden" name="foto_bd" value="<?php echo $foto; ?>">
                <input type="hidden" name="idUsuario" value="<?php echo $idUsuario; ?>">
                <button type="submit" name="btnContEditar">Continuar</button>
                <button type="submit">Atrás</button>
            </p>
    </form>
    <?php
}