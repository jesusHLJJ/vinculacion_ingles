<?php
include "../../BD.php";

$sql = "SELECT alumnos.matricula, alumnos.nombre, alumnos.ap_paterno, alumnos.ap_materno, usuarios.correo, carreras.nombre_carrera, alumnos.telefono, alumnos.sexo, niveles.nivel, documento_expediente.lin_captura_t, documento_expediente.fecha_entrega, documento_expediente.fecha_pago, estatus_alumnos.estatus_alumno FROM alumnos JOIN niveles ON alumnos.id_nivel = niveles.id_nivel JOIN carreras ON alumnos.id_carrera = carreras.id_carrera JOIN estatus_alumnos ON estatus_alumnos.id_estatus_alumno = alumnos.id_estatus JOIN documento_expediente ON documento_expediente.id_expediente = alumnos.id_expediente JOIN usuarios ON usuarios.id_usuario = alumnos.id_usuarios";
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