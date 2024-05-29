<?php
// Incluir el archivo de conexión a la base de datos
include "../../BD.php";

// Verificar si se recibieron los datos esperados
if (isset($_POST['nivel']) && isset($_FILES['constancias'])) {
    // Obtener el nivel enviado desde el formulario
    $nivel = $_POST['nivel'];

    // Obtener el nombre del grupo correspondiente al nivel desde la base de datos
    $grupo = obtenerNombreGrupo($conexion, $nivel);

    // Verificar si se obtuvo un grupo válido
    if ($grupo) {
        // Directorio donde se guardarán los archivos para este grupo
        $directorio = "../../CONSTANCIAS/$grupo/";

        // Verificar si el directorio existe, si no, crearlo
        if (!file_exists($directorio)) {
            mkdir($directorio, 0777, true);
        }

        $success = true; // Variable para verificar si todas las operaciones fueron exitosas

        // Recorrer cada archivo PDF recibido
        foreach ($_FILES['constancias']['tmp_name'] as $key => $tmp_name) {
            // Ruta final del archivo PDF
            $pdf_path = $directorio . basename($_FILES['constancias']['name'][$key]);

            // Mover el archivo PDF al directorio
            if (!move_uploaded_file($tmp_name, $pdf_path)) {
                $success = false;
                break; // Si ocurre un error al mover un archivo, detener el proceso
            }
        }

        // Verificar si todos los archivos se movieron correctamente
        if ($success) {
            // Insertar la ruta de la carpeta en la base de datos
            if (insertarRutaCarpetaEnBaseDeDatos($conexion, $nivel, $directorio)) {
                // Respuesta de éxito
                $response = array('success' => true);
                echo json_encode($response);
            } else {
                // Respuesta de error si ocurrió un problema al insertar la ruta de la carpeta en la base de datos
                $response = array('success' => false, 'message' => 'Error al insertar la ruta de la carpeta en la base de datos');
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
    $sql = "SELECT nivel FROM niveles WHERE id_nivel = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $nivel);
    $stmt->execute();
    $stmt->bind_result($grupo);
    $stmt->fetch();
    $stmt->close();
    return $grupo;
}

// Función para insertar la ruta de la carpeta en la base de datos
function insertarRutaCarpetaEnBaseDeDatos($conexion, $nivel_id, $directorio)
{
    $sql = "INSERT INTO documentos_nivel (id_nivel, acta_liberacion) VALUES (?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("is", $nivel_id, $directorio);
    $resultado = $stmt->execute();
    $stmt->close();
    return $resultado;
}
