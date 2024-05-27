<?php
include "../../BD.php";

// Verificar si se recibieron los datos esperados
if (isset($_POST['nivel']) && isset($_FILES['planeacion']) && isset($_FILES['avance1'])) {
    // Obtener el nivel enviado desde el formulario
    $nivel = $_POST['nivel'];

    // Obtener el nombre del grupo correspondiente al nivel desde la base de datos
    $grupo = obtenerNombreGrupo($conexion, $nivel);

    // Verificar si se obtuvo un grupo válido
    if ($grupo) {
        // Directorio donde se guardarán los archivos para este grupo
        $directorio = "../../PLANEACION_AVANCE/$grupo/";

        // Verificar si el directorio existe, si no, crearlo
        if (!file_exists($directorio)) {
            mkdir($directorio, 0777, true);
        }

        // Rutas finales de los documentos
        $planeacion_path = $directorio . basename($_FILES['planeacion']['name']);
        $avance1_path = $directorio . basename($_FILES['avance1']['name']);

        // Mover los archivos cargados al directorio
        if (
            moverArchivo($_FILES['planeacion']['tmp_name'], $planeacion_path) &&
            moverArchivo($_FILES['avance1']['tmp_name'], $avance1_path)
        ) {

            // Insertar las rutas de los archivos en la base de datos
            if (insertarRutasEnBaseDeDatos($conexion, $nivel, $planeacion_path, $avance1_path)) {
                // Respuesta de éxito
                $response = array('success' => true);
                echo json_encode($response);
            } else {
                // Respuesta de error si ocurrió un problema al insertar los datos
                $response = array('success' => false, 'message' => 'Error al insertar los datos en la base de datos');
                echo json_encode($response);
            }
        } else {
            // Respuesta de error si ocurrió un problema al mover los archivos
            $response = array('success' => false, 'message' => 'Error al mover los archivos');
            echo json_encode($response);
        }
    } else {
        // Respuesta de error si no se encontró el grupo correspondiente al nivel
        $response = array('success' => false, 'message' => 'Nivel no válido');
        echo json_encode($response);
    }
} else {
    // Respuesta de error si no se recibieron los datos esperados
    $response = array('success' => false, 'message' => 'Datos incompletos');
    echo json_encode($response);
}

// Función para obtener el nombre del grupo correspondiente al nivel desde la base de datos
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

// Función para mover un archivo al directorio especificado
function moverArchivo($archivo_temporal, $ruta_final)
{
    return move_uploaded_file($archivo_temporal, $ruta_final);
}

// Función para insertar las rutas de los archivos en la base de datos
function insertarRutasEnBaseDeDatos($conexion, $nivel, $planeacion_path, $avance1_path)
{
    $sql = "INSERT INTO documentos_profesor (id_nivel, planeacion_estrategica, avance_programatico_1) VALUES (?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("iss", $nivel, $planeacion_path, $avance1_path);
    $resultado = $stmt->execute();
    $stmt->close();
    return $resultado;
}
