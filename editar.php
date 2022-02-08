<?php
    include_once("conexion.php");

    $select_rack = ($_POST["select_rack"]);
    $ip = ($_POST["ip"]);
    $ip_ori = ($_POST["ip_ori"]);
    $descripcion = ($_POST["descri"]);
    $ubicacion = ($_POST["ubicac"]);
    $fecha = ($_POST["fecha"]);
    $personal = ($_POST["personal"]);
    $establecimiento = ($_POST["establecimiento"]);
    $red = ($_POST["red"]);
    $comentario = ($_POST["coment"]);
    $cambio = ($_POST["cambio"]);
    $date = date("d-m-Y");
    $estado = 1;
    $estado2 = 2;
    
    $sentencia = $conn->prepare("UPDATE registro_ip SET rack_nom = ?, ip_nom = ? , descripcion = ?, ubicacion = ?, fecha_ingreso = ?, personal_acargo = ?, establecimiento = ?, red = ?, comentario = ? ,fecha_instalacion = ? WHERE ip_nom = ?;");
    $resultado = $sentencia->execute([$select_rack, $ip,$descripcion,$ubicacion,$date,$personal,$establecimiento,$red,$comentario,$fecha,$ip_ori]);


    $sentencia2 = $conn->prepare("UPDATE ip SET estado = ? WHERE IP = ?;");
    $resultado2 = $sentencia2->execute([$estado,$ip_ori]);

    $sentencia3 = $conn->prepare("UPDATE ip SET estado = ? WHERE IP = ?;");
    $resultado3 = $sentencia3->execute([$estado2,$ip]);

    if($cambio == 1){
        if ($resultado === true) {
            if($resultado3 === true){
                if($resultado2 === true){
                    echo json_encode(1);
                }
                else{
                    echo json_encode(2);
                }
            }else {
                echo json_encode(2);
            }
        }
        else{
            echo json_encode(2);
        }
    }else if ($cambio == 0){
        if($resultado === true){
            echo json_encode(1);
        }else{
            echo json_encode(2);
        }
    }
    
?>