<?php
include "../../BD.php";
$sql = "SELECT administradores.id_admin, administradores.nombre, administradores.ap_paterno, administradores.ap_materno, usuarios.correo FROM administradores JOIN usuarios ON usuarios.id_usuario = administradores.id_usuario";
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
?>