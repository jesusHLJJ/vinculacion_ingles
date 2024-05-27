<?php
// Incluir tu archivo de conexión a la base de datos
include "../../BD.php";

// Verificar si se recibieron los datos del formulario
if (isset($_POST['nivel'], $_POST['grupo'], $_POST['profesor'], $_POST['cupo_max'], $_POST['periodo'], $_POST['modalidad'], $_POST['horario'], $_POST['aula'])) {
    // Obtener los datos del formulario
    $nivel = $_POST['nivel'];
    $grupo = $_POST['grupo'];
    $profesor = $_POST['profesor'];
    $cupo_max = $_POST['cupo_max'];
    $periodo = $_POST['periodo'];
    $modalidad = $_POST['modalidad'];
    $horario = $_POST['horario'];
    $aula = $_POST['aula'];

    // Preparar la consulta SQL para insertar los datos en la tabla de grupos
    $insert_query = "INSERT INTO niveles (nivel, grupo, id_profesor, cupo_max, id_periodo, modalidad, horario, aula) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt_insert = $conexion->prepare($insert_query);

    // Verificar si la preparación de la consulta fue exitosa
    if ($stmt_insert) {
        // Vincular los parámetros y ejecutar la consulta
        $stmt_insert->bind_param("ssisisss", $nivel, $grupo, $profesor, $cupo_max, $periodo, $modalidad, $horario, $aula);
        if ($stmt_insert->execute()) {
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
