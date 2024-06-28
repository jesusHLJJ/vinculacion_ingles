<?php
include "../../BD.php";

session_start();

if (isset($_GET['id_nivel'])) {
    $id_nivel = intval($_GET['id_nivel']);

    // Verificar la conexión a la base de datos
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // Obtener la ruta del archivo desde la base de datos
    $sql = "SELECT planeacion_estrategica FROM documentos_profesor WHERE id_nivel = ?";
    $stmt = $conexion->prepare($sql);

    if ($stmt === false) {
        die("Error de preparación de la consulta: " . $conexion->error);
    }

    $stmt->bind_param("i", $id_nivel);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $file_path = $row['planeacion_estrategica'];

        if (file_exists($file_path)) {
            // Forzar la descarga del archivo
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($file_path));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file_path));
            readfile($file_path);
            exit;
        } else {
            // Si el archivo no existe, redirigir a una página de error
            header("Location: info_grupo.php?error=archivo_no_encontrado");
            exit();
        }
    } else {
        // Si no se encuentra el registro, redirigir a una página de error
        header("Location: info_grupo.php?error=registro_no_encontrado");
        exit();
    }

    $stmt->close();
    $conexion->close();
} else {
    // Si no se proporciona id_nivel, redirigir a una página de error
    header("Location: info_grupo.php?error=parametro_faltante");
    exit();
}
