<?php
include "../../BD.php";

$sql = "SELECT alumnos.matricula, alumnos.nombre, alumnos.ap_paterno, alumnos.ap_materno, carreras.nombre_carrera, alumnos.telefono, alumnos.sexo, niveles.nivel, niveles.grupo, estatus_alumnos.estatus_alumno FROM alumnos JOIN niveles ON alumnos.id_nivel = niveles.id_nivel JOIN carreras ON alumnos.id_carrera = carreras.id_carrera JOIN estatus_alumnos ON estatus_alumnos.id_estatus_alumno = alumnos.id_estatus";
$result = $conexion->query($sql);

$grupos = [];

if ($result->num_rows > 0) {
    // Convertir resultados de la consulta a un array asociativo
    while ($row = $result->fetch_assoc()) {
        $grupos[] = $row;
    }
}

$conexion->close();

// Retornar los profesores en formato JSON
echo json_encode($grupos);