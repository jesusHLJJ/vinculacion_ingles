<?php
include "../../BD.php";

$sql = "SELECT id_nivel, nivel FROM niveles";
$result = $conexion->query($sql);

$niveles = [];

if ($result->num_rows > 0) {
    // Convertir resultados de la consulta a un array asociativo
    while ($row = $result->fetch_assoc()) {
        $niveles[] = $row;
    }
}

$conexion->close();

// Retornar las niveles en formato JSON
echo json_encode($niveles);