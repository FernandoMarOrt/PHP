<?php

    if(isset($_POST["btEnviar"])){                                                                                                          //ESTO PARA DECIR QUE LA IMAGEN SEA MYOR DE 500KB

        $error_archivo=$_FILES["archivo"]["name"]=="" && $_FILES["archivo"]["error"] || !getimagesize($_FILES["archivo"]["tmp_name"]) || $_FILES["archivo"]["size"] > 500*1024; //ESTO SE HACE PARA VER SI UN ARCHIVO ES IMAGEN O NO
        //para que da igual si se pone o no  $error_archivo=$_FILES["archivo"]["name"]=="";

        //archivo puede dar varias variables
        //name
        //error
        //size
        //type
        //tmp_name
    }

    if(isset($_POST["btEnviar"]) && !$error_archivo){

        echo "Contesto con la info del archivo subido";
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
            <form action="Archivos.php" method="post" enctype="multipart/form-data">
                <p>
                    <label for="archivo">Selecciona un archivo imagen (Max 500KB):</label>
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