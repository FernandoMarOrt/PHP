<?php
require "config_bd.php"; // Para los datos de la bd


function login ($usuario,$clave){
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
        
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
        return $respuesta;
    }
    
    try{
        $consulta = "select * from usuarios where usuario=? and clave=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$usuario,$clave]);
        
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
        $conexion=null;
        $sentencia=null;
        return $respuesta;
    }
    
    
    
    if($sentencia->rowCount()>0){
    
        $respuesta["usuario"]=$sentencia->fetch(PDO::FETCH_ASSOC);
        session_name("Prcaticando");
        session_start();
        $_SESSION["usuario"]= $respuesta["usuario"]["usuario"];
        $_SESSION["clave"]= $respuesta["usuario"]["clave"];
        $respuesta["api_session"]= session_id();
    
    }else{
    
        $respuesta["mensaje"]="usuario no registrado en la bd";
    }
    
    
    $conexion=null;
    $sentencia=null;
    return $respuesta;
}


function logueado ($usuario,$clave){
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
        
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
        return $respuesta;
    }
    
    try{
        $consulta = "select * from usuarios where usuario=? and clave=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$usuario,$clave]);
        
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
        $conexion=null;
        $sentencia=null;
        return $respuesta;
    }
    
    
    
    if($sentencia->rowCount()>0){
    
        $respuesta["usuario"]=$sentencia->fetch(PDO::FETCH_ASSOC);
    
    }else{
    
        $respuesta["mensaje"]="usuario no registrado en la bd";
    }
    
    
    $conexion=null;
    $sentencia=null;
    return $respuesta;
}



?>
