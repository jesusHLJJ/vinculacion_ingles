<?php
include "../../db.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verificar si todos los datos requeridos están presentes
    if (
        !empty($_POST['old_matricula']) &&
        !empty($_POST['new_matricula']) &&
        !empty($_POST['nombre']) &&
        !empty($_POST['paterno']) &&
        !empty($_POST['materno']) &&
        !empty($_POST['carreras']) &&
        !empty($_POST['telefono']) &&
        !empty($_POST['nivel']) &&
        !empty($_POST['estatus'])
    ) {
        // Capturar los datos
        $old_matricula = $_POST['old_matricula'];
        $new_matricula = $_POST['new_matricula'];
        $nombre = $_POST['nombre'];
        $paterno = $_POST['paterno'];
        $materno = $_POST['materno'];
        $carreras = $_POST['carreras'];
        $telefono = $_POST['telefono'];
        $nivel = $_POST['nivel'];
        $estatus = $_POST['estatus'];

        // Preparar la declaración SQL para actualizar los datos
        $sql_update = "UPDATE `alumnos` SET `matricula` = ?,`nombre` = ?,`ap_paterno` = ?,`ap_materno` = ?,`id_carrera` = ?,`telefono` = ?, `id_nivel` = ?,`id_estatus` = ? WHERE `matricula` = ?";
        $stmt_update = $conexion->prepare($sql_update);

        if ($stmt_update) {
            // Vincular los parámetros
            $stmt_update->bind_param("isssisiii", $new_matricula, $nombre, $paterno, $materno, $carreras, $telefono, $nivel, $estatus, $old_matricula);

            // Ejecutar la declaración
            if ($stmt_update->execute()) {
                echo json_encode(array('success' => true, 'redirectUrl' => '../ALUMNOS/'));
            } else {
                echo json_encode(array('success' => false, 'message' => 'Error al ejecutar la actualización'));
            }

            // Cerrar la declaración
            $stmt_update->close();
        } else {
            echo json_encode(array('success' => false, 'message' => 'Error al preparar la declaración'));
        }

        // Cerrar la conexión
        $conexion->close();
    } else {
        echo json_encode(array('success' => false, 'message' => 'Datos incompletos'));
    }
} else {
    echo json_encode(array('success' => false, 'message' => 'Método no permitido'));
}
