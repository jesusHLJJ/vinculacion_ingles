<?php
include "../../db.php";

$sql = "SELECT niveles.id_nivel, niveles.nivel, niveles.grupo, profesores.nombre, niveles.cupo_max, periodos.periodo, niveles.modalidad, niveles.horario, niveles.aula FROM niveles JOIN profesores ON niveles.id_profesor = profesores.id_profesor JOIN periodos ON niveles.id_periodo = periodos.id_periodo";
$result = $conexion->query($sql);

$niveles = [];

if ($result->num_rows > 0) {
    // Convertir resultados de la consulta a un array asociativo
    while ($row = $result->fetch_assoc()) {
        $niveles[] = $row;
    }
}

$conexion->close();

// Retornar los profesores en formato JSON
echo json_encode($niveles);
?>