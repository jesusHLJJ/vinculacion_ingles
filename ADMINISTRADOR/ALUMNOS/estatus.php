<?php
include "../../db.php";

$sql = "SELECT * FROM estatus_alumnos";
$result = $conexion->query($sql);

$estatus_a = [];

if ($result->num_rows > 0) {
    // Convertir resultados de la consulta a un array asociativo
    while ($row = $result->fetch_assoc()) {
        $estatus_a[] = $row;
    }
}

$conexion->close();

// Retornar los profesores en formato JSON
echo json_encode($estatus_a);