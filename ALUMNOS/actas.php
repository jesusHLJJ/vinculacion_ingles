<?php
include '../BD.php';
session_start();
$matricula = $_SESSION['matricula'];

$sql = "select niveles.grupo, alumnos.id_expediente from alumnos join niveles on alumnos.id_nivel=niveles.id_nivel where matricula=$matricula";
$stmt = $conexion->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
// Verificar si se encontraron resultados
if ($result->num_rows > 0) {
    // Obtener el nombre de la fila
    $fila = $result->fetch_assoc();
    $grupo = $fila['grupo'];
    $expediente = $fila['id_expediente'];
}

$ruta_archivo = "../CONSTANCIAS/$grupo/$expediente"."acta.pdf";
$file_exists = file_exists($ruta_archivo);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VER ACTAS</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <?php
    if ($file_exists) {
        header('Content-type: application/pdf');
        readfile($ruta_archivo);
    } else {
        echo "<script>var fileExists = false;</script>";
    }
    ?>
    <script>
        if (typeof fileExists !== 'undefined' && !fileExists) {
            Swal.fire({
                title: 'NO HAY INFORMACIÓN DISPONIBLE',
                icon: 'error',
                confirmButtonText: 'Aceptar',
                confirmButtonColor:'#ffbb00'
            }).then(() => {
                window.location.href = '../ALUMNOS/alumnos.php';
            });
        }
    </script>
</body>

</html>
