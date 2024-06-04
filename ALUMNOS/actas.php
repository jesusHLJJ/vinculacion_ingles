<?php include '../BD.php';
session_start();

//$ruta_archivo = 'C:\Users\da7ca\Desktop\actas_grupo_1A.pdf';
$ruta_archivo ='C:\Users\da7ca\Documents\Universidad\Servicio social\Documentos de prueba\Documentos de alumno\actas_grupo_1A.pdf';


?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VER ACTAS</title>
</head>

<body>
    <?php
    if (file_exists($ruta_archivo)) {
        header('Content-type: application/pdf');
        readfile($ruta_archivo);
    } else {
        echo "El archivo no existe.";
    }
    ?>
    </form>
</body>

</html>