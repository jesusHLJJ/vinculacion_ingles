<?php
include "../../BD.php";

$matricula = $_GET['matricula'];

if (!$matricula) {
    echo "Matrícula no proporcionada.";
    exit;
}

// Obtener el id_expediente a partir de la matrícula
$id_expediente_query = "SELECT id_expediente FROM alumnos WHERE matricula = '$matricula'";
$id_expediente_result = $conexion->query($id_expediente_query);

if ($id_expediente_result === false) {
    echo "Error en la consulta SQL para obtener id_expediente: " . $conexion->error;
    exit;
}

if ($id_expediente_result->num_rows > 0) {
    $id_expediente_row = $id_expediente_result->fetch_assoc();
    $id_expediente = $id_expediente_row['id_expediente'];

    // Consulta para obtener las rutas de los archivos desde la tabla documento_expediente
    $expediente_query = "SELECT const_na, comp_pago, lin_captura FROM documento_expediente WHERE id_expediente = '$id_expediente'";
    $expediente_result = $conexion->query($expediente_query);

    if ($expediente_result === false) {
        echo "Error en la consulta SQL para obtener archivos: " . $conexion->error;
        exit;
    }

    if ($expediente_result->num_rows > 0) {
        $expediente_row = $expediente_result->fetch_assoc();

        $files = [
            'const_na' => $expediente_row['const_na'],
            'comp_pago' => $expediente_row['comp_pago'],
            'lin_captura' => $expediente_row['lin_captura']
        ];

        // Crear un archivo ZIP con todos los archivos
        $zip = new ZipArchive();
        $zipFileName = tempnam(sys_get_temp_dir(), 'files_') . '.zip';

        if ($zip->open($zipFileName, ZipArchive::CREATE) !== TRUE) {
            exit("No se puede abrir el archivo <$zipFileName>\n");
        }

        foreach ($files as $name => $file) {
            if (file_exists($file)) {
                $zip->addFile($file, basename($file));
            }
        }

        $zip->close();

        // Forzar la descarga del archivo ZIP
        header('Content-Type: application/zip');
        header('Content-disposition: attachment; filename=archivos_' . $matricula . '.zip');
        header('Content-Length: ' . filesize($zipFileName));
        readfile($zipFileName);

        // Eliminar el archivo temporal ZIP
        unlink($zipFileName);
    } else {
        echo "No se encontraron archivos para el id_expediente proporcionado.";
    }
} else {
    echo "No se encontró id_expediente para la matrícula proporcionada.";
}

$conexion->close();
?>
