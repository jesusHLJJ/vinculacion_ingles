<?php
include "../../BD.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verificar si todos los datos requeridos están presentes
    if (
        !empty($_POST['id']) &&
        !empty($_POST['nivel']) &&
        !empty($_POST['grupo']) &&
        !empty($_POST['profesor']) &&
        !empty($_POST['cupo_max']) &&
        !empty($_POST['periodo']) &&
        !empty($_POST['modalidad']) &&
        !empty($_POST['horario']) &&
        !empty($_POST['aula'])
    ) {
        // Capturar los datos
        $id = $_POST['id'];
        $nivel = $_POST['nivel'];
        $grupo = $_POST['grupo'];
        $profesor = $_POST['profesor'];
        $cupo_max = $_POST['cupo_max'];
        $periodo = $_POST['periodo'];
        $modalidad = $_POST['modalidad'];
        $horario = $_POST['horario'];
        $aula = $_POST['aula'];

        // Preparar la declaración SQL para actualizar los datos
        $sql_update = "UPDATE `niveles` SET `nivel` = ?, `grupo` = ?, `id_profesor` = ?, `cupo_max` = ?, `id_periodo` = ?, `modalidad` = ?, `horario` = ?, `aula` = ? WHERE `id_nivel` = ?";
        $stmt_update = $conexion->prepare($sql_update);

        if ($stmt_update) {
            // Vincular los parámetros
            $stmt_update->bind_param("ssisisssi", $nivel, $grupo, $profesor, $cupo_max, $periodo, $modalidad, $horario, $aula, $id);

            // Ejecutar la declaración
            if ($stmt_update->execute()) {
                echo json_encode(array('success' => true, 'redirectUrl' => '../PROFESORES/'));
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
