<?php
use Psr\Http\Message\UploadedFileInterface;
if(isset($_POST["equipo"]))
{
    $url=DIR_SERV."/deGuardia/".$_POST["dia"]."/".$_POST["hora"]."/".$datos_usuario_log->id_usuario;
    $respuesta=consumir_servicios_REST($url,"GET",$datos);
    $obj=json_decode($respuesta);
    if(!$obj)
    {
        session_destroy();
        die(error_page("Gestión de guardias","<h1>Gestión de Guardias</h1><p>Error consumiendo el servicio: ".$url."</p>"));
    }

    if(isset($obj->error))
    {
        consumir_servicios_REST(DIR_SERV."/salir","POST",$datos);
        session_destroy();
        die(error_page("Gestión de guardias","<h1>Gestión de Guardias</h1><p>".$obj->error."</p>"));
    }

    if(isset($obj->no_auth))
    {
        session_unset();
        $_SESSION["seguridad"]="El tiempo de sesión de la API ha caducado";
        header("Location:../index.php");
        exit;
    }
    
    if($obj->de_guardia)
    {
        $url=DIR_SERV."/usuariosGuardia/".$_POST["dia"]."/".$_POST["hora"];
        $respuesta=consumir_servicios_REST($url,"GET",$datos);
        $obj2=json_decode($respuesta);
        if(!$obj2)
        {
            session_destroy();
            die(error_page("Gestión de guardias","<h1>Gestión de Guardias</h1><p>Error consumiendo el servicio: ".$url."</p>"));
        }

        if(isset($obj2->error))
        {
            consumir_servicios_REST(DIR_SERV."/salir","POST",$datos);
            session_destroy();
            die(error_page("Gestión de guardias","<h1>Gestión de Guardias</h1><p>".$obj2->error."</p>"));
        }

        if(isset($obj2->no_auth))
        {
            session_unset();
            $_SESSION["seguridad"]="El tiempo de sesión de la API ha caducado";
            header("Location:../index.php");
            exit;
        }
    }
    if(isset($_POST["btnDetalles"]))
    {
        $url=DIR_SERV."/usuario/".$_POST["btnDetalles"];
        $respuesta=consumir_servicios_REST($url,"GET",$datos);
        $obj3=json_decode($respuesta);
        if(!$obj3)
        {
            session_destroy();
            die(error_page("Gestión de guardias","<h1>Gestión de Guardias</h1><p>Error consumiendo el servicio: ".$url."</p>"));
        }

        if(isset($obj3->error))
        {
            consumir_servicios_REST(DIR_SERV."/salir","POST",$datos);
            session_destroy();
            die(error_page("Gestión de guardias","<h1>Gestión de Guardias</h1><p>".$obj3->error."</p>"));
        }

        if(isset($obj3->no_auth))
        {
            session_unset();
            $_SESSION["seguridad"]="El tiempo de sesión de la API ha caducado";
            header("Location:../index.php");
            exit;
        }
    }

}


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Guardias</title>
    <style>
        .enlinea{display:inline}
        .enlace{background:none;border:none;text-decoration:underline;color:blue;cursor:pointer}
        table, th, td{border:1px solid black}
        table{border-collapse:collapse; width:80%;margin:0 auto;text-align: center;}
        th{background-color:#CCC}
        .izq {text-align:left}
      
    </style>
</head>
<body>
    <h1>Gestión de Guardias</h1>
    <div>
        Bienvenido <strong><?php echo $datos_usuario_log->usuario;?></strong> - <form class='enlinea' action="index.php" method="post"><button name="btnSalir" type="submit" class='enlace'>Salir</form> 
    </div>
    <?php
    $dias[]="";
    $dias[]="Lunes";
    $dias[]="Martes";
    $dias[]="Miércoles";
    $dias[]="Jueves";
    $dias[]="Viernes";

    echo "<h2>Equipos de Guardia del IES Mar de Alborán</h2>";
    echo "<table>";
    echo "<tr>";
    for($i=0;$i<=5;$i++)
    {
        echo "<th>".$dias[$i]."</th>";
    }
    echo "</tr>";
    $contador=1;
    for($hora=1;$hora<=6;$hora++)
    {
        if($hora==4)
        {
            echo "<tr><td colspan='6'>RECREO</td></tr>";
        }
        echo "<tr>";
        echo "<td>".$hora."º Hora</td>";
        for($dia=1;$dia<=5;$dia++)
        {
            echo "<td>";
            echo "<form action='index.php' method='post'>";
            echo "<input type='hidden' value='".$dia."' name='dia'><input type='hidden' value='".$hora."' name='hora'>";
            echo "<input type='hidden' value='".$contador."' name='equipo'>";
            echo "<button name='btnGuardia' class='enlace'>Equipo ".$contador."</button>";
            echo "</form>";
            echo "</td>";
            $contador++;
        }
        echo "</tr>";
    }
    echo "</table>";

    if(isset($_POST["equipo"]))
    {
        echo "<h1>EQUIPO DE GUARDIA ".$_POST["equipo"]."</h1>";
        if($obj->de_guardia)
        {
            echo "<h3>".$dias[$_POST["dia"]]." a ".$_POST["hora"]."º hora</h3>";

            $n_profesores=count($obj2->usuarios);
            echo "<table>";
            echo "<tr>";
            echo "<th>Profesores de Guardia</th>";
            echo "<th>Información del Profesor con id_usuario: ";
            if(isset($_POST["btnDetalles"]))
                echo $_POST["btnDetalles"];
            echo "</th>";
            echo "</tr>";
            foreach($obj2->usuarios as $key => $tupla)
            {
                echo "<tr>";
                echo "<td>";
                echo "<form action='index.php' method='post'>";
                echo "<input type='hidden' value='".$_POST["dia"]."' name='dia'><input type='hidden' value='".$_POST["hora"]."' name='hora'>";
                echo "<input type='hidden' value='".$_POST["equipo"]."' name='equipo'>";
                echo "<button name='btnDetalles' value='".$tupla->id_usuario."' class='enlace'>".$tupla->nombre."</button>";
                echo "</form>";
                echo "</td>";
                if($key==0)
                {
                    echo "<td class='izq' rowspan='".$n_profesores."'>";
                    if(isset($_POST["btnDetalles"]))
                    {
                        echo "<p><strong>Nombre: </strong>".$obj3->usuario->nombre."</p>";
                        echo "<p><strong>Usuario: </strong>".$obj3->usuario->usuario."</p>";
                        echo "<p><strong>Contraseña: </strong></p>";
                        echo "<p><strong>Email: </strong>";
                        if(isset($obj3->usuario->email))
                            echo $obj3->usuario->email;
                        else
                            echo "Email no disponible";
                        echo "</p>";
                    }
                    echo "</td>";
            
                }
                
                echo "</tr>";
            }
            echo "</table>";

        }
        else
            echo "<h3>¡¡ Usted no se encuentra de Guardia el ".$dias[$_POST["dia"]]." a ".$_POST["hora"]."º hora !!</h3>";
    }
    ?>
</body>
</html>