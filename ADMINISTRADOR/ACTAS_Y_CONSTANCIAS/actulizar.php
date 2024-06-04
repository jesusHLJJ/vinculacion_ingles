<?php
// Incluir el archivo de conexión a la base de datos
include "../../BD.php";

// Verificar si se recibieron los datos esperados
if (isset($_FILES['constancias']) && isset($_POST['grupo'])) {
    // Obtener el grupo enviado desde el formulario
    $grupo = $_POST['grupo'];

    // Verificar si se obtuvo un grupo válido
    if ($grupo) {
        // Directorio donde se guardarán los archivos para este grupo
        $directorio = "../../CONSTANCIAS/$grupo/";

        // Verificar si el directorio existe, si no, crearlo
        if (!file_exists($directorio)) {
            mkdir($directorio, 0777, true);
        }

        // Array para guardar las rutas de los archivos
        $constancias_paths = [];

        // Mover los archivos cargados al directorio
        foreach ($_FILES['constancias']['tmp_name'] as $key => $tmp_name) {
            $file_name = basename($_FILES['constancias']['name'][$key]);
            $file_path = $directorio . $file_name;

            if (move_uploaded_file($tmp_name, $file_path)) {
                $constancias_paths[] = $file_path;
            } else {
                // Respuesta de error si ocurrió un problema al mover los archivos
                $response = array('success' => false, 'message' => 'Error al mover los archivos');
                echo json_encode($response);
                exit;
            }
        }

        // Insertar las rutas de los archivos en la base de datos
        $idnivel = obtenerIdNivel($conexion, $grupo);
        if ($idnivel) {
            $constancias_paths_serialized = serialize($constancias_paths);
            if (insertarRutasEnBaseDeDatos($conexion, $idnivel, $directorio)) {
                // Respuesta de éxito
                $response = array('success' => true);
                echo json_encode($response);
            } else {
                // Respuesta de error si ocurrió un problema al insertar los datos
                $response = array('success' => false, 'message' => 'Error al insertar los datos en la base de datos');
                echo json_encode($response);
            }
        } else {
            // Respuesta de error si no se encontró el grupo correspondiente al id
            $response = array('success' => false, 'message' => 'Grupo no válido');
            echo json_encode($response);
        }
    } else {
        // Respuesta de error si no se encontró el grupo correspondiente al id
        $response = array('success' => false, 'message' => 'Grupo no válido');
        echo json_encode($response);
    }
} else {
    // Respuesta de error si no se recibieron los datos esperados
    $response = array('success' => false, 'message' => 'Datos incompletos');
    echo json_encode($response);
}

// Función para obtener el id del nivel correspondiente al grupo desde la base de datos
function obtenerIdNivel($conexion, $grupo)
{
    $idnivel = null;
    $sql = "SELECT id_nivel FROM niveles WHERE grupo = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $grupo);
    $stmt->execute();
    $stmt->bind_result($idnivel);
    $stmt->fetch();
    $stmt->close();
    return $idnivel;
}

// Función para insertar las rutas de los archivos en la base de datos
function insertarRutasEnBaseDeDatos($conexion, $idnivel, $directorio)
{
    $sql = "UPDATE documentos_nivel SET acta_liberacion = ? WHERE id_nivel = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("si", $directorio, $idnivel);
    $resultado = $stmt->execute();
    $stmt->close();
    return $resultado;
}
