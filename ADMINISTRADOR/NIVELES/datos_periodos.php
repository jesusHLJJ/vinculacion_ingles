<?php
include "../../BD.php";

$sql = "SELECT * FROM periodos";
$result = $conexion->query($sql);

$periodos = [];

if ($result->num_rows > 0) {
    // Convertir resultados de la consulta a un array asociativo
    while ($row = $result->fetch_assoc()) {
        $periodos[] = $row;
    }
}

$conexion->close();

// Retornar los profesores en formato JSON
echo json_encode($periodos);
?>