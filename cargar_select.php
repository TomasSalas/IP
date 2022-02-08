<?php
    
    include_once("conexion.php");

    $grupo = ($_POST["grupo"]);
    $estado = 1;

    $sentencia = $conn->prepare("SELECT id_ip , ip  FROM IP WHERE GRUPO_RACK = ? AND ESTADO = ? ORDER BY ID_IP ASC");
    $sentencia -> execute([$grupo,$estado]);
    $resultado2 = $sentencia->fetchAll(PDO::FETCH_OBJ);

    $html = "<option  class='form-control' value='0'>Seleccione:</option>";

    foreach ($resultado2 as $row){
        $html .=  "<option class='form-control' value='".$row->id_ip."'>".$row->ip."</option>";
    }
    echo $html;
?>