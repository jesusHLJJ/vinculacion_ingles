<?php
include "../../BD.php";

if (isset($_POST['nombre'])) {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $pass = $_POST['password'];

    $hash = password_hash($pass, PASSWORD_DEFAULT);
    $tipo_usuario = 2;
    $id_estatus = 1;

    $insert_profesor = 'INSERT INTO profesores(id_estatus, nombres,correo) VALUES(?, ?, ?)';
    $stmt_insert_profesor = $conexion->prepare($insert_profesor);
    $stmt_insert_profesor->bind_param("iss", $id_estatus, $nombre, $correo);

    if ($stmt_insert_profesor->execute()) {
        $stmt_insert_profesor->close();

        $insert_login = 'INSERT INTO login_usuarios(correo, contrasena, id_tipo) VALUES(?, ?, ?)';
        $stmt_insert_login = $conexion->prepare($insert_login);
        $stmt_insert_login->bind_param("ssi", $correo, $hash, $tipo_usuario);

        if ($stmt_insert_login->execute()) {
            $stmt_insert_login->close();
            echo '<script>alert("Datos ingresados correctamente");window.location="../profesores.php";</script>';
            exit;
        } else {
            $stmt_insert_login->close();
        } 
    } else {
        $stmt_insert_profesor->close();
    }
    echo '<script>alert("Error al capturar los datos, intente de nuevo");window.location="../tutores.php";</script>';
    exit;
}
?>