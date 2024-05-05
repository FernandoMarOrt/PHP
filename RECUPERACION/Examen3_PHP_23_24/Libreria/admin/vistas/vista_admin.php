<?php
if (isset($_POST["btnAgregar"])) {
    $error_referencia = $_POST["referencia"] == "" || !is_numeric($_POST["referencia"]) || $_POST["referencia"] < 0;
    if (!$error_referencia) {
        $error_referencia = repetido($conexion, "libros", "referencia", $_POST["referencia"]);
        if (is_string($error_referencia)) {
            session_destroy();
            $conexion = null;
            die(error_page("Examen3 Curso 23-24", "<h1>Librería</h1><p>Error en la consulta: " . $error_referencia . "</p>"));
        }
    }
    $error_titulo = $_POST["titulo"] == "";
    $error_autor = $_POST["autor"] == "";
    $error_descripcion = $_POST["descripcion"] == "";
    $error_precio = $_POST["precio"] == "" || !is_numeric($_POST["precio"]) || $_POST["precio"] <= 0;
    $array_nombre = explode(".", $_FILES["portada"]["name"]);
    $error_portada = $_FILES["portada"]["name"] != "" && ($_FILES["portada"]["error"] || !$array_nombre || !getimagesize($_FILES["portada"]["tmp_name"]) || $_FILES["portada"]["size"] > 750 * 1024);
    $error_form = $error_referencia || $error_titulo || $error_autor || $error_descripcion || $error_precio || $error_portada;
    if (!$error_form) {

        try {
            $consulta = "insert into libros(referencia, titulo,autor,descripcion,precio) values (?,?,?,?,?)";
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute([$_POST["referencia"], $_POST["titulo"], $_POST["autor"], $_POST["descripcion"], $_POST["precio"]]);
            $sentencia = null;
        } catch (PDOException $e) {
            $sentencia = null;
            $conexion = null;
            session_destroy();
            die(error_page("Examen3 Curso 23-24", "<h1>Librería</h1><p>Error en la consulta: " . $e->getMessage() . "</p>"));
        }

        $_SESSION["accion"] = "Libro agregado con éxito";
        // realizo la inserccion de la foto
        if ($_FILES["portada"]["name"] != "") {

            $ultm_refe = $_POST["referencia"];

            $array_ext = explode(".", $_FILES["portada"]["name"]);
            $ext = "." . end($array_ext);
            $nombre_nuevo = "img_" . $ultm_refe . $ext;
            @$var = move_uploaded_file($_FILES["portada"]["tmp_name"], "../images/" . $nombre_nuevo);

            if ($var) {
                try {

                    $consulta = "update libros set portada=? where referencia=?";
                    $sentencia = $conexion->prepare($consulta);
                    $sentencia->execute([$nombre_nuevo,  $ultm_refe]);
                    $sentencia = null;
                } catch (PDOException $e) {
                    if (file_exists("../images/" . $nombre_nuevo))
                        unlink("../images/" . $nombre_nuevo);
                    $sentencia = null;
                    $conexion = null;
                    $mensaje = "Usuario insertado con éxito pero con la imagen por defecto por un problema en la BD del servidor";
                }
            } else {
                $mensaje = "Usuario insertado con éxito pero con la imagen por defecto ya que no se ha podido mover la imagen a la carpeta destino en el servidor";
            }
        }
    }
}
if (isset($_POST["btnBorrar"])) {
    try {

        $consulta = "DELETE from libros where referencia=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$_POST["btnBorrar"]]);
        if ($_POST["portada"] != FOTO_DEFECTO && file_exists("images/" . $_POST["portada"]))
            unlink("images/" . $_POST["foto"]);

        $sentencia = null;
        $conexion = null;
        $_SESSION["accion"] = "El libro ha sido borrado con exito";
        $_SESSION["pag"] = 1; //Al poner paginación cuándo borro siempre me voy página
        header("Location:gest_libros.php");
        exit;
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        session_destroy();
        die(error_page("Práctica Rec 2", "<h1>Práctica Rec 2</h1><p>Imposible realizar la consulta. Error:" . $e->getMessage() . "</p>"));
    }
}
if (isset($_POST["btnEditar"])) {
    $_SESSION["accion"] = "EL libro con referencia " . $_POST["btnEditar"] . " se ha editado con éxito";
    $conexion = null;
    header("Location:gest_libros.php");
    exit;
}
/*Aqui la gestion de paginación*/
if (isset($_POST["btnPag"]))
    $_SESSION["pag"] = $_POST["btnPag"];


if (!isset($_SESSION["pag"]))
    $_SESSION["pag"] = 1;

if (isset($_POST["registros"])) {
    $_SESSION["regs_mostrar"] = $_POST["registros"];
    $_SESSION["buscar"] = $_POST["buscar"];
    $_SESSION["pag"] = 1;
}

if (!isset($_SESSION["regs_mostrar"]))
    $_SESSION["regs_mostrar"] = 3;



if (!isset($_SESSION["buscar"]))
    $_SESSION["buscar"] = "";

if ($_SESSION["regs_mostrar"] == -1) {
    $n_pags = 1;
} else {
    $ini_pag = ($_SESSION["pag"] - 1) * $_SESSION["regs_mostrar"];

    try {

        if ($_SESSION["buscar"] == "") {
            $consulta = "SELECT * FROM libros ";
        } else {
            $consulta = "SELECT * FROM libros  WHERE titulo LIKE '%" . $_SESSION["buscar"] . "%'";
        }
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute();
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        session_destroy();
        die(error_page("Práctica Examen_3", "<h1>Práctica Examen 3</h1><p>Imposible realizar la consulta. Error:" . $e->getMessage() . "</p>"));
    }

    $total_registros = $sentencia->rowCount();
    $sentencia = null;
    $n_pags = ceil($total_registros / $_SESSION["regs_mostrar"]);
}
/*****consulta para mostra la tabla******/

try {

    if ($_SESSION["buscar"] == "") {

        if ($_SESSION["regs_mostrar"] == -1)
            $consulta = "SELECT * FROM libros";
        else
            $consulta = "SELECT * FROM libros LIMIT " . $ini_pag . "," . $_SESSION["regs_mostrar"];
    } else {
        if ($_SESSION["regs_mostrar"] == -1)
            $consulta = "SELECT * FROM libros WHERE titulo LIKE '%" . $_SESSION["buscar"] . "%'";
        else
            $consulta = "SELECT * FROM libros WHERE titulo LIKE '%" . $_SESSION["buscar"] . "%' LIMIT " . $ini_pag . "," . $_SESSION["regs_mostrar"];
    }
    $sentencia = $conexion->prepare($consulta);
    $sentencia->execute();
} catch (PDOException $e) {
    $sentencia = null;
    $conexion = null;
    session_destroy();
    die(error_page("Examen Rec_3", "<h1>Examne Rec_3</h1><p>Imposible realizar la consulta. Error:" . $e->getMessage() . "</p>"));
}
$libros = $sentencia->fetchAll(PDO::FETCH_ASSOC);
$sentencia = null;






?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .error {
            color: red
        }

        .en_linea {
            display: inline
        }

        .enlace {
            border: none;
            background: none;
            color: blue;
            text-decoration: underline;
            cursor: pointer
        }

        table {
            border-collapse: collapse;
            width: 40%;
        }

        table,
        th,
        td {
            border: 1px solid black
        }

        th {
            background-color: #CCC
        }

        .reducida {
            height: 100px
        }

        .img_editar {
            width: 30%
        }

        .centrar {
            width: 80%;
            margin: 0 auto;
        }

        .mensaje {
            font-size: 1.25rem;
            color: blue
        }

        #t_editar,
        #t_editar td {
            border: none
        }

        .centrado {
            text-align: center;
        }

        .d_flex {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5em
        }



        .list_libros {
            border: 1px solid black;
            margin: 0.5rem;
            flex: 0 25%;
        }

        body {
            display: flex;
            flex-direction: column;
            flex-wrap: wrap;
        }

        .segundo {
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
        }

        .h1segundo {
            flex: 1 100%;
        }

        .buscador {
            flex: 1 100%;
        }

        .contenedor {
            flex: 1 100%;
        }

        .botones {
            flex: 1 100%;
        }
    </style>
</head>

<body>

    <div class="primero">
        Bienvenido <strong><?php echo $datos_usuario_log["lector"]; ?></strong> -
        <form class="en_linea" action="../index.php" method="post">
            <button class="enlace" name="btnSalir" type="submit">Salir</button>
        </form>
    </div>
    <?php
    if (isset($_SESSION["accion"])) {
        echo "<p class='mensaje'>" . $_SESSION["accion"] . "</p>";
        unset($_SESSION["accion"]);
    }
    ?>

    <div class="segundo">
        <h1 class="h1segundo">Listado de los Libros</h1>
        <div class='buscador'>
            <form id='form_regs_filtro' class="d_flex" action='gest_libros.php' method='post'>
                <div>
                    Mostrar
                    <select name='registros' onchange='document.getElementById("form_regs_filtro").submit();'>
                        <option <?php if ($_SESSION["regs_mostrar"] == 3) echo "selected"; ?> value='3'>3</option>
                        <option <?php if ($_SESSION["regs_mostrar"] == 6) echo "selected"; ?> value='6'>6</option>
                        <option <?php if ($_SESSION["regs_mostrar"] == -1) echo "selected"; ?> value='-1'>TODOS</option>
                    </select>
                    registros por página
                </div>
                <div>
                    <input type="text" name="buscar" value="<?php echo $_SESSION["buscar"]; ?>"><button type="submit" name="btnBuscar">Buscar</button>
                </div>
        </div>
        <?php
        echo "<table class='contenedor'>";
        echo "<tr><th>Ref</th><th>Título</th><th>Acción</th></tr>";
        foreach ($libros as $tupla) {
            echo "<tr>";
            echo "<td>" . $tupla["referencia"] . "</td>";
            echo "<td>" . $tupla["titulo"] . "</td>";
            echo "<td><form action='' method='post'><button class='enlace' type='submit' value='" . $tupla["referencia"] . "' name='btnBorrar'>Borrar</button>-<button class='enlace' name='btnEditar' value='" . $tupla["referencia"] . "'>Editar</button></form></td>";
            echo "</tr>";
        }
        echo "</table>";
        if ($n_pags > 1) {
            echo "<div class='botones'>";
            echo "<form action='gest_libros.php' method='post'>";
            echo "<p>";
            if ($_SESSION["pag"] != 1) {
                echo "<button  type='submit' name='btnPag' value='1'>|<</button> ";
                echo "<button  type='submit' name='btnPag' value='" . ($_SESSION["pag"] - 1) . "'><</button> ";
            }

            for ($i = 1; $i <= $n_pags; $i++) {
                if ($_SESSION["pag"] == $i)
                    echo "<button disabled type='submit' name='btnPag' value='" . $i . "'>" . $i . "</button> ";
                else
                    echo "<button  type='submit' name='btnPag' value='" . $i . "'>" . $i . "</button> ";
            }
            if ($_SESSION["pag"] != $n_pags) {
                echo "<button  type='submit' name='btnPag' value='" . ($_SESSION["pag"] + 1) . "'>></button> ";
                echo "<button  type='submit' name='btnPag' value='" . $n_pags . "'>>|</button> ";
            }

            echo "</p>";
            echo "</form>";
            echo "</div>";
        }

        ?>

    </div>

    </div>

    <div class="tercero">
        <h3>Agregar un libro nuevo</h3>
        <form action="gest_libros.php" method="post" enctype="multipart/form-data">
            <p>
                <label for="referencia">Referencia:</label>
                <input type="text" name="referencia" id="referencia" value="<?php if (isset($_POST["referencia"])) echo $_POST["referencia"]; ?>">
                <?php
                if (isset($_POST["referencia"]) && $error_referencia) {
                    if ($_POST["referencia"] == "")
                        echo "<span class='error'> Campo Vacío</span>";
                    elseif (!is_numeric($_POST["referencia"]) || $_POST["referencia"] < 0)
                        echo "<span class='error'> Referencia no es un número mayor o igual que cero</span>";
                    else
                        echo "<span class='error'> Referencia repetida</span>";
                }
                ?>
            </p>
            <p>
                <label for="titulo">Título:</label>
                <input type="text" name="titulo" id="titulo" value="<?php if (isset($_POST["titulo"])) echo $_POST["titulo"]; ?>">
                <?php
                if (isset($_POST["titulo"]) && $error_titulo)
                    echo "<span class='error'> Campo Vacío</span>";
                ?>
            </p>
            <p>
                <label for="autor">Autor:</label>
                <input type="text" name="autor" id="autor" value="<?php if (isset($_POST["autor"])) echo $_POST["autor"]; ?>">
                <?php
                if (isset($_POST["autor"]) && $error_autor)
                    echo "<span class='error'> Campo Vacío</span>";
                ?>
            </p>
            <p>
                <label for="descripcion">Descripción:</label>
                <textarea name="descripcion" id="descripcion"><?php if (isset($_POST["descripcion"])) echo $_POST["descripcion"]; ?></textarea>
                <?php
                if (isset($_POST["descripcion"]) && $error_descripcion)
                    echo "<span class='error'> Campo Vacío</span>";
                ?>
            </p>
            <p>
                <label for="precio">Precio:</label>
                <input type="text" name="precio" id="precio" value="<?php if (isset($_POST["precio"])) echo $_POST["precio"]; ?>">
                <?php
                if (isset($_POST["precio"]) && $error_precio) {
                    if ($_POST["precio"] == "")
                        echo "<span class='error'> Campo Vacío</span>";
                    else
                        echo "<span class='error'> El precio debe ser un número mayor que cero</span>";
                }
                ?>
            </p>
            <p>
                <label for="portada">Portada:</label>
                <input type="file" name="portada" id="portada" accept="image/*">
                <?php
                if (isset($_POST["btnAgregar"]) && $error_portada) {
                    if ($_FILES["portada"]["error"])
                        echo "<span class='error'>Error en la subida del fichero</span>";
                    elseif (!explode(".", $_FILES["portada"]["name"]))
                        echo "<span class='error'>El archivo seleccionado no tiene extensión</span>";
                    elseif (!getimagesize($_FILES["portada"]["tmp_name"]))
                        echo "<span class='error'>El archivo seleccionado no es un archivo imagen</span>";
                    else
                        echo "<span class='error'>El archivo seleccionado supera los 750KB</span>";
                }

                ?>
            </p>
            <p>
                <button type="submit" name="btnAgregar">Agregar</button>
            </p>
        </form>

</body>

</html>