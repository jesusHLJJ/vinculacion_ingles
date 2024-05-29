<?php

include "../BD.php";

session_start();
if (isset($_GET['id_nivel']) && isset($_GET['parcial'])) {
    $id_nivel = intval($_GET['id_nivel']);
    $parcial = intval($_GET['parcial']);
    $column_name = '';

    switch ($parcial) {
        case 1:
            $column_name = 'avance_programatico_1';
            break;
        case 2:
            $column_name = 'avance_programatico_2';
            break;
        case 3:
            $column_name = 'avance_programatico_3';
            break;
        default:
            header("Location: info_grupo.php");
            exit();
    }

    $sql = "SELECT $column_name FROM documentos_profesor WHERE id_nivel = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id_nivel);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $file_path = $row[$column_name];

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
            exit();
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
