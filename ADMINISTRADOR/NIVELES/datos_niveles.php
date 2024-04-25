<?php
include "../../BD.php";

$sql = "SELECT grupos.id_grupo, grupos.nivel, grupos.nombre_grupo, profesores.nombres, grupos.cupo_maximo, grupos.modalidad, profesores.turno, grupos.horario FROM grupos JOIN profesores ON grupos.id_profesor = profesores.id_profesor";
$result = $conexion->query($sql);

$niveles = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $niveles[] = $row;
    }
}

$conexion->close();

echo json_encode($niveles)
?>