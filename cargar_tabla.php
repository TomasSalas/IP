<?php
    require_once("conexion.php");

    $sentencia = $conn->query("select ip_nom, rack_nom, descripcion , ubicacion , fecha_ingreso, personal_acargo , establecimiento ,red, comentario , fecha_instalacion 
    from registro_ip order by id_registroip DESC");
    $registro = $sentencia->fetchAll(PDO::FETCH_OBJ);
    $table="";
    
    foreach ($registro as $curreg) {
        $table .=
        "<tr>
        <td>$curreg->ip_nom</td>
        <td>$curreg->rack_nom</td>
        <td>$curreg->descripcion</td>
        <td>$curreg->ubicacion</td>
        <td>$curreg->fecha_ingreso</td>
        <td>$curreg->personal_acargo</td>
        <td>$curreg->establecimiento</td>
        <td>$curreg->red</td>
        <td>$curreg->comentario</td>
        <td>$curreg->fecha_instalacion</td>
        <td><button type='button' class='btn btn-success editar-btn' data-id=$curreg->ip_nom>Seleccionar</button> </td>
        </tr>";
    }
    echo json_encode($table);
?>