<?php
// Incluir tu archivo de conexión a la base de datos
include "../../BD.php";

// Verificar si se recibieron los datos del formulario
if (isset($_POST['grupo'], $_POST['profesor'], $_POST['nivel'], $_POST['periodo'], $_POST['modalidad'], $_POST['horario'], $_POST['cupo_min'], $_POST['cupo_max'], $_POST['aula'], $_POST['ciclo'], $_POST['turno'])) {
    // Obtener los datos del formulario
    $grupo = $_POST['grupo'];
    $profesor = $_POST['profesor'];
    $nivel = $_POST['nivel'];
    $periodo = $_POST['periodo'];
    $modalidad = $_POST['modalidad'];
    $horario = $_POST['horario'];
    $cupo_min = $_POST['cupo_min'];
    $cupo_max = $_POST['cupo_max'];
    $aula = $_POST['aula'];
    $ciclo = $_POST['ciclo'];
    $turno = $_POST['turno'];

    // Preparar la consulta SQL para insertar los datos en la tabla de grupos
    $insert_query = "INSERT INTO grupos (nombre_grupo, id_profesor, nivel, id_periodo, modalidad, horario, cupo_minimo, cupo_maximo, aula, ciclo_escolar) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt_insert = $conexion->prepare($insert_query);
    
    // Verificar si la preparación de la consulta fue exitosa
    if ($stmt_insert) {
        // Vincular los parámetros y ejecutar la consulta
        $stmt_insert->bind_param("sisissssss", $grupo, $profesor, $nivel, $periodo, $modalidad, $horario, $cupo_min, $cupo_max, $aula, $ciclo);
        if ($stmt_insert->execute()) {
            // Si la inserción en la tabla de grupos fue exitosa, actualizar la tabla de profesores
            $update_query = "UPDATE profesores SET modalidad = ?, nivel = ?, turno = ? WHERE id_profesor = ?";
            $stmt_update = $conexion->prepare($update_query);

            // Verificar si la preparación de la consulta de actualización fue exitosa
            if ($stmt_update) {
                // Vincular los parámetros y ejecutar la consulta de actualización
                $stmt_update->bind_param("sssi", $modalidad, $nivel, $turno, $profesor);
                $stmt_update->execute();
                $stmt_update->close();
            } else {
                // Si hubo un error al preparar la consulta de actualización, enviar una respuesta de error al cliente
                echo json_encode(array('success' => false, 'message' => 'Error al preparar la consulta de actualización de profesores'));
                exit();
            }

            // Enviar una respuesta de éxito al cliente
            echo json_encode(array('success' => true));
        } else {
            // Si hubo un error al ejecutar la consulta de inserción en la tabla de grupos, enviar una respuesta de error al cliente
            echo json_encode(array('success' => false, 'message' => 'Error al insertar los datos en la base de datos (grupos)'));
        }
        
        // Cerrar la declaración de inserción
        $stmt_insert->close();
    } else {
        // Si hubo un error al preparar la consulta de inserción en la tabla de grupos, enviar una respuesta de error al cliente
        echo json_encode(array('success' => false, 'message' => 'Error al preparar la consulta de inserción en la base de datos (grupos)'));
    }
} else {
    // Si no se recibieron todos los datos del formulario, enviar una respuesta de error al cliente
    echo json_encode(array('success' => false, 'message' => 'Faltan datos del formulario'));
}

// Cerrar la conexión a la base de datos
$conexion->close();
?>
