<?php
    try {
        $conn = new PDO("pgsql:host=10.68.120.2;port=5432;dbname=hospitalqtades", "postgres", "fall13*hqta");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (Exception $e) {
        echo "Ocurrió un error con la base de datos: " . $e->getMessage();
    }
?>