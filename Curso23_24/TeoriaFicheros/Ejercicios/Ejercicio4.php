<?php

    if(isset($_POST["btEnviar"])){   

        $array_nombre=explode(".",$_FILES["archivo"]["name"]);
        $extension="";//PARA EXTENSION VACIA
        if(count($array_nombre)>1){ //SI NO LLEVA EXTENSION

            $extension=".".end($array_nombre);
                        
        }

        $error_archivo=$_FILES["archivo"]["name"]=="" && $_FILES["archivo"]["error"] || !getimagesize($_FILES["archivo"]["tmp_name"]) || $_FILES["archivo"]["size"] > 2500*1024 || $extension != ".txt"; 
        
    }

    if(isset($_POST["btEnviar"]) && !$error_archivo){
        ?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Ejercicio4</title>
                <style>.tam_imag{width:35%}</style>
            </head>
            <body>
                <?php
                    echo "<p>Funciona</p>";
                ?>
                
            </body>
            </html>

        <?php
    } else{


?>

        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Subir archivos al servidor</title>
            <style>
                .error{color:red};
            </style>
        </head>
        <body>
            
            <h1>Teoria subir ficheros al servidor</h1>
            <form action="Ejercicio4.php" method="post" enctype="multipart/form-data">
                <p>
                    <label for="archivo">Selecciona un archivo imagen (Max 2.5MB):</label>
                    <input type="file" name="archivo" id="archivo" accept="image/*">
                    <?php

                        if(isset($_POST["btEnviar"]) && $error_archivo) {

                            if($_FILES["archivo"]["name"]!=""){ //Si he seleccionado algo

                                if($_FILES["archivo"]["error"]){ //Si da error
 
                                    echo "<span class='error'>No se ha podido subir el archivo</<span>";
    
                                }elseif(!getimagesize($_FILES["archivo"]["tmp_name"])){ //SI no selecciona una imagen
    
                                    echo "<span class='error'>No has seleccionado un archivo de tipo imagen</<span>";
    
                                }else{ //SI supera el peso
    
                                    echo "<span class='error'>El archivo seleccionado supera los 500KB</<span>";
                                }
                            }

                           

                        }


                    ?>
                </p>


                <p>
                    <button type="submit" name="btEnviar">Enviar</button>
                </p>
            </form>
        </body>
        </html>
    <?php
    }
    ?>