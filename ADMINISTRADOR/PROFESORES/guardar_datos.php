<?php
include "../../db.php";

if (isset($_POST['correo'], $_POST['password'])) {
    $correo = $_POST['correo'];
    $pass = $_POST['password'];

    $hash = password_hash($pass, PASSWORD_DEFAULT);
    $tipo_usuario = 2;
    $estatus = "Activo";

    // Inicia una transacción
    $conexion->begin_transaction();

    $insert_login = 'INSERT INTO usuarios(correo, contrasena, id_tipo) VALUES(?, ?, ?)';
    $stmt_insert_login = $conexion->prepare($insert_login);
    $stmt_insert_login->bind_param("ssi", $correo, $hash, $tipo_usuario);

    if ($stmt_insert_login->execute()) {
        $stmt_insert_login->close(); // Cerrar el statement preparado

        $id_usuario = $conexion->insert_id;
        $insert_profesor = 'INSERT INTO profesores(estatus, id_usuario) VALUES(?, ?)';
        $stmt_insert_profesor = $conexion->prepare($insert_profesor);
        $stmt_insert_profesor->bind_param("si", $estatus, $id_usuario);

        if ($stmt_insert_profesor->execute()) {
            // Confirma la transacción
            $conexion->commit();
            $stmt_insert_profesor->close(); // Cerrar el statement preparado
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
