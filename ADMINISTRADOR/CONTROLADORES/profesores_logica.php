<?php
include "../../BD.php";

if (isset($_POST['nombre'], $_POST['correo'], $_POST['password'])) {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $pass = $_POST['password'];

    $hash = password_hash($pass, PASSWORD_DEFAULT);
    $tipo_usuario = 2;
    $id_estatus = 1;

    // Inicia una transacción
    $conexion->begin_transaction();

    $insert_profesor = 'INSERT INTO profesores(id_estatus, nombres, correo) VALUES(?, ?, ?)';
    $stmt_insert_profesor = $conexion->prepare($insert_profesor);
    $stmt_insert_profesor->bind_param("iss", $id_estatus, $nombre, $correo);

    if ($stmt_insert_profesor->execute()) {
        $stmt_insert_profesor->close(); // Cerrar el statement preparado

        $insert_login = 'INSERT INTO login_usuarios(correo, contrasena, id_tipo) VALUES(?, ?, ?)';
        $stmt_insert_login = $conexion->prepare($insert_login);
        $stmt_insert_login->bind_param("ssi", $correo, $hash, $tipo_usuario);

        if ($stmt_insert_login->execute()) {
            // Confirma la transacción
            $conexion->commit();
            $stmt_insert_login->close(); // Cerrar el statement preparado
            echo json_encode(array('success' => true));
            exit;
        } else {
            $conexion->rollback(); // Deshace la transacción
            $stmt_insert_login->close(); // Cerrar el statement preparado
        }
    }

    $stmt_insert_profesor->close(); // Cerrar el statement preparado
    echo json_encode(array('success' => false, 'message' => 'Error al capturar los datos, inténtelo de nuevo'));
    exit;
}
?>