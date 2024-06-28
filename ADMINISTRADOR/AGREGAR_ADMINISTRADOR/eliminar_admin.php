<?php
include "../../BD.php";

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['correo'])) {
    $correo = $data['correo'];

    // Eliminar el usuario
    $stmt = $conexion->prepare("DELETE FROM usuarios WHERE correo = ?");
    $stmt->bind_param("s", $correo);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al eliminar el usuario']);
    }

    $stmt->close();
    $conexion->close();
} else {
    echo json_encode(['success' => false, 'message' => 'ID no proporcionado']);
}
