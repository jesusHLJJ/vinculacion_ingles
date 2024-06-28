<?php
include "../../BD.php";

if (isset($_POST['nombre'], $_POST['paterno'], $_POST['materno'], $_POST['correo'], $_POST['password'])) {
    $nombre = $_POST['nombre'];
    $paterno = $_POST['paterno'];
    $materno = $_POST['materno'];
    $correo = $_POST['correo'];
    $pass = $_POST['password'];

    $hash = password_hash($pass, PASSWORD_DEFAULT);
    $tipo_usuario = 1;

    // Inicia una transacción
    $conexion->begin_transaction();

    $insert_login = 'INSERT INTO usuarios(correo, contrasena, id_tipo) VALUES(?, ?, ?)';
    $stmt_insert_login = $conexion->prepare($insert_login);
    $stmt_insert_login->bind_param("ssi", $correo, $hash, $tipo_usuario);

    if ($stmt_insert_login->execute()) {
        $stmt_insert_login->close(); // Cerrar el statement preparado

        $id_usuario = $conexion->insert_id;
        $insert_profesor = 'INSERT INTO administradores(nombre, ap_paterno, ap_materno, id_usuario) VALUES(?, ?, ?, ?)';
        $stmt_insert_profesor = $conexion->prepare($insert_profesor);
        $stmt_insert_profesor->bind_param("sssi", $nombre, $paterno, $materno, $id_usuario);

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
