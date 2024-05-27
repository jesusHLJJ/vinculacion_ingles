<?php
include "../../db.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['estatus']) && !empty($_POST['id'])) {
        $id = $_POST['id'];
        $estatus = $_POST['estatus'];

        $sql_update = "UPDATE `profesores` SET `estatus` = ? WHERE `id_profesor` = ?";
        $stmt_update = $conexion->prepare($sql_update);

        if ($stmt_update) {
            $stmt_update->bind_param("si", $estatus, $id);
            
            if ($stmt_update->execute()) {
                echo json_encode(array('success' => true, 'redirectUrl' => '../PROFESORES/'));
            } else {
                echo json_encode(array('success' => false, 'message' => 'Error al ejecutar la actualización'));
            }
            
            $stmt_update->close();
        } else {
            echo json_encode(array('success' => false, 'message' => 'Error al preparar la declaración'));
        }

        $conexion->close();
    } else {
        echo json_encode(array('success' => false, 'message' => 'Datos incompletos'));
    }
} else {
    echo json_encode(array('success' => false, 'message' => 'Método no permitido'));
}
?>
