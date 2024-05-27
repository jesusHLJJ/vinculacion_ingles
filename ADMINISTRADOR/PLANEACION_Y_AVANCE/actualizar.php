<?php
include "../../BD.php";

if (isset($_POST['id']) && isset($_POST['nivel'])) {
    $id = $_POST['id'];
    $nivel = $_POST['nivel'];

    $grupo = obtenerNombreGrupo($conexion, $nivel);

    if ($grupo) {
        $directorio = "../../PLANEACION_AVANCE/$grupo/";

        if (!file_exists($directorio)) {
            mkdir($directorio, 0777, true);
        }

        // Obtener rutas existentes
        $planeacion_existente = obtenerRutaExistente($conexion, $id, 'planeacion_estrategica');
        $avance1_existente = obtenerRutaExistente($conexion, $id, 'avance_programatico_1');
        $avance2_existente = obtenerRutaExistente($conexion, $id, 'avance_programatico_2');
        $avance3_existente = obtenerRutaExistente($conexion, $id, 'avance_programatico_3');

        // Establecer rutas predeterminadas
        $planeacion_path = $planeacion_existente;
        $avance1_path = $avance1_existente;
        $avance2_path = $avance2_existente;
        $avance3_path = $avance3_existente;

        // Verificar si se están enviando nuevos archivos y moverlos si es necesario
        if (isset($_FILES['planeacion']) && $_FILES['planeacion']['tmp_name']) {
            $planeacion_path = $directorio . basename($_FILES['planeacion']['name']);
            if (moverArchivo($_FILES['planeacion']['tmp_name'], $planeacion_path) && $planeacion_existente) {
                unlink($planeacion_existente);
            }
        }

        if (isset($_FILES['avance1']) && $_FILES['avance1']['tmp_name']) {
            $avance1_path = $directorio . basename($_FILES['avance1']['name']);
            if (moverArchivo($_FILES['avance1']['tmp_name'], $avance1_path) && $avance1_existente) {
                unlink($avance1_existente);
            }
        }

        if (isset($_FILES['avance2']) && $_FILES['avance2']['tmp_name']) {
            $avance2_path = $directorio . basename($_FILES['avance2']['name']);
            if (moverArchivo($_FILES['avance2']['tmp_name'], $avance2_path) && $avance2_existente) {
                unlink($avance2_existente);
            }
        }

        if (isset($_FILES['avance3']) && $_FILES['avance3']['tmp_name']) {
            $avance3_path = $directorio . basename($_FILES['avance3']['name']);
            if (moverArchivo($_FILES['avance3']['tmp_name'], $avance3_path) && $avance3_existente) {
                unlink($avance3_existente);
            }
        }

        // Actualizar rutas en la base de datos
        if (actualizarRutasEnBaseDeDatos($conexion, $id, $planeacion_path, $avance1_path, $avance2_path, $avance3_path)) {
            // Respuesta de éxito
            $response = array('success' => true);
            echo json_encode($response);
        } else {
            // Respuesta de error si hay un problema al actualizar las rutas en la base de datos
            $response = array('success' => false, 'message' => 'Error al actualizar las rutas en la base de datos');
            echo json_encode($response);
        }
    } else {
        // Respuesta de error si el nivel no es válido
        $response = array('success' => false, 'message' => 'Nivel no válido');
        echo json_encode($response);
    }
} else {
    // Respuesta de error si los datos son incompletos
    $response = array('success' => false, 'message' => 'Datos incompletos');
    echo json_encode($response);
}

function obtenerNombreGrupo($conexion, $nivel)
{
    $grupo = null;
    $sql = "SELECT grupo FROM niveles WHERE id_nivel = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $nivel);
    $stmt->execute();
    $stmt->bind_result($grupo);
    $stmt->fetch();
    $stmt->close();
    return $grupo;
}

function moverArchivo($archivo_temporal, $ruta_final)
{
    return move_uploaded_file($archivo_temporal, $ruta_final);
}

function obtenerRutaExistente($conexion, $id, $campo)
{
    $sql = "SELECT $campo FROM documentos_profesor WHERE id_documento = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        return null; // No se encontraron resultados
    } else {
        $row = $result->fetch_assoc();
        return $row[$campo]; // Retorna el valor del campo específico
    }
}

function actualizarRutasEnBaseDeDatos($conexion, $id, $planeacion_path, $avance1_path, $avance2_path, $avance3_path)
{
    $sql = "UPDATE documentos_profesor SET planeacion_estrategica = ?, avance_programatico_1 = ?, avance_programatico_2 = ?, avance_programatico_3 = ? WHERE id_documento = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ssssi", $planeacion_path, $avance1_path, $avance2_path, $avance3_path, $id);
    $resultado = $stmt->execute();
    $stmt->close();
    return $resultado;
}
