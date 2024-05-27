<?php
include "../../BD.php";

$sql = "SELECT documentos_profesor.id_documento, niveles.grupo, documentos_profesor.planeacion_estrategica, documentos_profesor.avance_programatico_1, documentos_profesor.avance_programatico_2, documentos_profesor.avance_programatico_3, documentos_profesor.planecion_profesor, documentos_profesor.avance_profesor_1, documentos_profesor.avance_profesor_2, documentos_profesor.avance_profesor_3 FROM documentos_profesor JOIN niveles ON documentos_profesor.id_nivel = niveles.id_nivel";

$result = $conexion->query($sql);

$documentos = [];

if ($result->num_rows > 0) {
    // Convertir resultados de la consulta a un array asociativo
    while ($row = $result->fetch_assoc()) {
        $documentos[] = $row;
    }
}

$conexion->close();

// Retornar las documentos en formato JSON
echo json_encode($documentos);
?>