<?php
include "../../BD.php";

$sql = "SELECT * FROM carreras";
$result = $conexion->query($sql);

$carreras = [];

if ($result->num_rows > 0) {
    // Convertir resultados de la consulta a un array asociativo
    while ($row = $result->fetch_assoc()) {
        $carreras[] = $row;
    }
}

$conexion->close();

// Retornar las carreras en formato JSON
echo json_encode($carreras);
?>