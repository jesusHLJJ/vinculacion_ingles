<?php
include '../BD.php';
session_start();

if (!isset($_SESSION['tipo'])) {
    header('location: ../');
} else {
    if ($_SESSION['tipo'] != 3) {
        header('location: ../');
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['volver'])) {
        header("Location:alumnos.php");
    }
}
error_reporting(0);
ini_set('display_errors', 0);

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

$directory = "../CONSTANCIAS/$grupo";
$pdfFiles = glob($directory . "/*.pdf");
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VER ACTAS</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="estilos/actas.css">
</head>

<body>
    <div class="container">
        <h1>VER ACTAS</h1>
        <?php
        if ($pdfFiles) {
            echo '<table>';
            echo '<tr><th>ARCHIVO PDF</th></tr>';
            foreach ($pdfFiles as $file) {
                echo "<tr><td><a href='$file' target='_blank'>" . basename($file) . "</a></td></tr>";
            }
            echo '</table>';
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
                confirmButtonColor: '#ffbb00'
            }).then(() => {
                window.location.href = '../ALUMNOS/alumnos.php';
            });
        }
    </script>
    <br><br>
     <form action="" method="post">
        <input type="submit" id="volver" name="volver" value=VOLVER>
    </form>
    </div>
</body>

</html>
