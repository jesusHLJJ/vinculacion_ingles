<?php
include "../../BD.php";

$sql = "SELECT alumnos.nombre, alumnos.ap_paterno, alumnos.ap_materno, tipos_usuarios.tipo_usuario, usuarios.correo FROM alumnos JOIN usuarios ON usuarios.id_usuario = alumnos.id_usuarios JOIN tipos_usuarios ON tipos_usuarios.id_tipo = usuarios.id_tipo
UNION
SELECT profesores.nombre, profesores.ap_paterno, profesores.ap_materno, tipos_usuarios.tipo_usuario, usuarios.correo FROM profesores JOIN usuarios ON usuarios.id_usuario = profesores.id_usuario JOIN tipos_usuarios ON tipos_usuarios.id_tipo = usuarios.id_tipo
UNION
SELECT administradores.nombre, administradores.ap_paterno, administradores.ap_materno, tipos_usuarios.tipo_usuario, usuarios.correo FROM administradores JOIN usuarios ON usuarios.id_usuario = administradores.id_usuario JOIN tipos_usuarios ON tipos_usuarios.id_tipo = usuarios.id_tipo";
$result = $conexion->query($sql);

$datos = [];

if ($result->num_rows > 0) {
    // Convertir resultados de la consulta a un array asociativo
    while ($row = $result->fetch_assoc()) {
        $datos[] = $row;
    }
}

$conexion->close();

// Retornar los profesores en formato JSON
echo json_encode($datos);
