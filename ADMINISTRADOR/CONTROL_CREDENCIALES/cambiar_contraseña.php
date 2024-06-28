<?php
include "../../BD.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obtener los datos del POST
    $new_pass = $_POST['new_pass'];
    $correo = $_POST['correo'];

    // Validar los datos
    if (empty($new_pass) || empty($correo)) {
        echo json_encode(['status' => 'error', 'message' => 'Datos incompletos']);
        exit;
    }

    // Encriptar la nueva contraseña
    $hashed_password = password_hash($new_pass, PASSWORD_DEFAULT);

    // Actualizar la contraseña en la base de datos
    $stmt = $conexion->prepare("UPDATE usuarios SET contrasena = ? WHERE correo = ?");
    $stmt->bind_param("ss", $hashed_password, $correo);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error al actualizar la contraseña']);
    }

    // Cerrar la conexión
    $stmt->close();
    $conexion->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Método no permitido']);
}
?>
