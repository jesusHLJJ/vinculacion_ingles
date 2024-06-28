<?php
include "../../BD.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['id']) && !empty($_POST['nombre']) && !empty($_POST['paterno']) && !empty($_POST['materno']) && !empty($_POST['correo_nuevo']) && !empty($_POST['correo_viejo'])) {
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $paterno = $_POST['paterno'];
        $materno = $_POST['materno'];
        $correo_viejo = $_POST['correo_viejo'];
        $correo_nuevo = $_POST['correo_nuevo'];

        // Obtener el id_usuario del correo antiguo en la tabla 'usuarios'
        $sql_obtener_id = "SELECT `id_usuario` FROM `usuarios` WHERE `correo` = ?";
        $stmt_obtener_id = $conexion->prepare($sql_obtener_id);
        $stmt_obtener_id->bind_param("s", $correo_viejo);
        
        if ($stmt_obtener_id->execute()) {
            $stmt_obtener_id->bind_result($id_usuario);
            $stmt_obtener_id->fetch();
            $stmt_obtener_id->close();

            // Actualizar el correo en la tabla 'usuarios' utilizando el id_usuario obtenido
            $sql_correo = "UPDATE `usuarios` SET `correo` = ? WHERE `id_usuario` = ?";
            $stmt_correo = $conexion->prepare($sql_correo);
            $stmt_correo->bind_param("si", $correo_nuevo, $id_usuario);
            if ($stmt_correo->execute()) {
                $stmt_correo->close();

                // Actualización de los datos en la tabla 'administradores'
                $sql_update = "UPDATE `administradores` SET `nombre` = ?, `ap_paterno` = ?, `ap_materno` = ? WHERE `id_admin` = ?";
                $stmt_update = $conexion->prepare($sql_update);
                $stmt_update->bind_param("sssi", $nombre, $paterno, $materno, $id);

                if ($stmt_update->execute()) {
                    echo json_encode(array('success' => true, 'redirectUrl' => '../AGREGAR_ADMINISTRADOR/'));
                } else {
                    echo json_encode(array('success' => false, 'message' => 'Error al ejecutar la actualización de administradores'));
                }

                $stmt_update->close();
            } else {
                echo json_encode(array('success' => false, 'message' => 'Error al actualizar el correo'));
            }

            $conexion->close();
        } else {
            echo json_encode(array('success' => false, 'message' => 'Error al obtener el id_usuario'));
        }
    } else {
        echo json_encode(array('success' => false, 'message' => 'Datos incompletos'));
    }
} else {
    echo json_encode(array('success' => false, 'message' => 'Método no permitido'));
}
?>
