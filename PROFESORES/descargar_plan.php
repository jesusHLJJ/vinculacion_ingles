<?php

include "../BD.php";

session_start();
if (isset($_GET['id_nivel'])) {
    $id_nivel = intval($_GET['id_nivel']);
    echo $id_nivel;
    // Obtener la ruta del archivo desde la base de datos
    $sql = "SELECT planeacion_estrategica FROM documentos_profesor WHERE id_nivel = ?";
    $stmt = $conexion->prepare($sql);
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
            header("Location: info_grupo.php");
            exit();
        }
    } else {
        header("Location: info_grupo.php");
        exit();
    }
} else {
    header("Location: info_grupo.php");
    exit();
}
?>
