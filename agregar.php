<?php
    include_once("conexion.php");


    $select_rack = ($_POST["select_rack"]);
    $ip = ($_POST["ip"]);
    $descripcion = ($_POST["descri"]);
    $ubicacion = ($_POST["ubicac"]);
    $fecha = ($_POST["fecha"]);
    $personal = ($_POST["personal"]);
    $establecimiento = ($_POST["establecimiento"]);
    $red = ($_POST["red"]);
    $comentario = ($_POST["coment"]);
    $estado = 2;

    $date = date("d-m-Y");

    $sentencia3 = $conn->prepare("SELECT * FROM registro_ip WHERE ip_nom = ?;");
    $sentencia3->execute([$ip]);
    $registro = $sentencia3->fetchObject();

    if($registro){
        echo $data = 33;
    }
    else{
        $sentencia = $conn->prepare("INSERT INTO registro_ip (rack_nom, ip_nom, descripcion, ubicacion, fecha_ingreso, personal_acargo, establecimiento, red, comentario,fecha_instalacion) VALUES (?,?,?,?,?,?,?,?,?,?);");
        $resultado = $sentencia->execute([$select_rack,$ip,$descripcion,$ubicacion,$date,$personal,$establecimiento,$red,$comentario,$fecha]);
        if ($resultado === TRUE) {
            $sentencia2 = $conn->prepare("UPDATE IP SET ESTADO = ? WHERE IP = ?");
            $resultado2 = $sentencia2->execute([$estado,$ip]);
        if($resultado2 === TRUE){
            echo $data = 1;
        }
    
        } else {
            echo $data = 2;
        }
        
    };





?>
