<h2>Agregar Nueva Pelicula</h2>
    <form action="index.php" method="post" enctype="multipart/form-data">
        <p>
            <label for="titulo">Titulo de la pelicula</label><br/>
            <input type="text" name="titulo" id="titulo" maxlength="15" value="<?php if(isset($_POST["titulo"])) echo $_POST["titulo"];?>"/>
            <?php
            if(isset($_POST["btnContNueva"])&& $error_titulo)
            {
                if($_POST["titulo"]=="")
                    echo "<span class='error'> Campo vacío </span>";
                elseif(strlen($_POST["titulo"])>15)
                    echo "<span class='error'> Has tecleado más de 15 caracteres</span>";
                else 
                    echo "<span class='error'>Titulo repetido</span>";
            }
            ?>
        </p>
        <p>
            <label for="director">Director de la pelicula</label><br/>
            <input type="text" name="director" id="director" maxlength="20" value="<?php if(isset($_POST["director"])) echo $_POST["director"];?>"/>
            <?php
            if(isset($_POST["btnContNueva"])&& $error_director)
            {
                if($_POST["director"]=="")
                    echo "<span class='error'> Campo vacío </span>";
                else
                    echo "<span class='error'> Has tecleado más de 20 caracteres</span>";
            }
                
            ?>
        </p>
        <p>
            <label for="clave">Contraseña</label><br/>
            <input type="password" name="clave" id="clave" maxlength="15"/>
            <?php
            if(isset($_POST["btnContNueva"])&& $error_clave)
            {
                if($_POST["clave"]=="")
                    echo "<span class='error'> Campo vacío </span>";
                else
                    echo "<span class='error'> Has tecleado más de 15 caracteres</span>";
            }
            ?>
        </p>
        <p>
            <label for="dni">DNI:</label><br/>
            <input type="text" placeholder="DNI: 11223344Z" maxlength="9" name="dni" id="dni" value="<?php if(isset($_POST["dni"])) echo $_POST["dni"];?>"/>
            <?php
            if(isset($_POST["btnContNueva"])&& $error_dni)
            {
                if($_POST["dni"]=="")
                    echo "<span class='error'> Campo vacío </span>";
                elseif(!dni_bien_escrito($dni_may))
                    echo "<span class='error'> DNI no está bien escrito </span>";
                elseif(!dni_valido($dni_may))
                    echo "<span class='error'> DNI no válido </span>";
                else
                    echo "<span class='error'> DNI repetido </span>";
            }
                
            ?>
        </p>

        <p>Sexo
        <?php
            if(isset($_POST["btnContNueva"])&& $error_sexo)
                echo "<span class='error'> Debes seleccionar un Sexo </span>";
            ?>
            <br/>
            <input type="radio" <?php if(isset($_POST["sexo"]) && $_POST["sexo"]=="hombre") echo "checked";?> name="sexo" id="hombre" value="hombre"/><label for="hombre">Hombre</label><br/>
            <input type="radio" <?php if(isset($_POST["sexo"]) && $_POST["sexo"]=="mujer") echo "checked";?> name="sexo" id="mujer" value="mujer"/><label for="mujer">Mujer</label>
        </p>
        <p>
            <label for="foto">Incluir mi foto (Max. 500KB)</label>
            <input type="file" name="foto" id="foto" accept="image/*"/>
            <?php
            if(isset($_POST["btnContNueva"]) && $error_foto)
            {
                if($_FILES["foto"]["error"])
                    echo "<span class='error'> No se ha podido subir el archivo al servidor</span>";
                elseif(!getimagesize( $_FILES["foto"]["tmp_name"]))
                    echo "<span class='error'> No has seleccionado un archivo de tipo imagen</span>";
                elseif(!tiene_extension($_FILES["foto"]["name"]))
                    echo "<span class='error'> Has seleccionado un archivo imagen sin extensión</span>";
                else
                    echo "<span class='error'> El archivo seleccionado supera los 500KB</span>";
            }
            ?>
        </p>
        
        
        <p>
            <button type="submit" name="btnContNueva">Guardar Cambios</button>
            <button type="submit" >Atras</button>
        </p>
        
    </form>