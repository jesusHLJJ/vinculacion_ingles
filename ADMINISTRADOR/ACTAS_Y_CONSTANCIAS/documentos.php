<?php
include "../../BD.php";

$sql = "SELECT documentos_nivel.id_documento, niveles.nivel, documentos_nivel.acta_calificacion, documentos_nivel.acta_liberacion FROM documentos_nivel JOIN niveles ON documentos_nivel.id_nivel = niveles.id_nivel";

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