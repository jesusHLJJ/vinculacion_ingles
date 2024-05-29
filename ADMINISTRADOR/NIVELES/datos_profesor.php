<?php
include "../../BD.php";

$sql = "SELECT * FROM profesores WHERE estatus = 'Activo'";
$result = $conexion->query($sql);

$profesores = [];

if ($result->num_rows > 0) {
    // Convertir resultados de la consulta a un array asociativo
    while ($row = $result->fetch_assoc()) {
        $profesores[] = $row;
    }
}

$conexion->close();

// Retornar los profesores en formato JSON
echo json_encode($profesores);
?>