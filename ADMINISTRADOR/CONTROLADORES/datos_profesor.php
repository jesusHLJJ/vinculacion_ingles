<?php
include "../../BD.php";

$sql = "SELECT profesores.id_profesor, profesores.nombres, estatus_profesor.estatus_profesor, profesores.edad, estado_civil.estado_civil, profesores.sexo, profesores.calle, profesores.rfc, profesores.modalidad, profesores.nivel, profesores.turno FROM profesores JOIN estatus_profesor ON profesores.id_estatus = estatus_profesor.id_estatus JOIN estado_civil ON profesores.id_estado_civil = estado_civil.id_estado_civil";
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