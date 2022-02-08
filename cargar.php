<?php
    require_once("conexion.php");

    $id_equipo = ($_POST["id_equipo"]);
    
    $sentencia = $conn->prepare("SELECT * FROM REGISTRO_IP WHERE ip_nom = ?;");
    $sentencia->execute([$id_equipo]);
    $registro = $sentencia->fetchObject();
    if (!$registro) {
    echo "¡No existe IP!";
    exit();
    }
    else{
        echo json_encode($registro);
    }
?>
