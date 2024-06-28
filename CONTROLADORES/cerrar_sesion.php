<?php
include "../BD.php";

$sql = "SELECT * FROM usuarios WHERE id_tipo=1";
$stmt = $conexion->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
// Verificar si se encontraron resultados
if ($result->num_rows > 0) {
    $fila = $result->fetch_assoc();
    $correo_verificacion = $fila['correo'];
    if($correo_verificacion = 'admin@admin.com'){
        $sql = "SELECT correo FROM usuarios WHERE correo='admin@admin.com'";
        $result = $conexion->query($sql);
        if ($result) {
            $sql = "DELETE FROM usuarios WHERE correo='admin@admin.com'";
            $result = $conexion->query($sql);
    
            session_start();
            session_unset();
            session_destroy();
            header("Cache-Control: no-store, no-cache, must-revalidate");
            header("Pragma: no-cache");
            header('location: ../');
            exit;
        }
    }
    else{
            
        $showAlert = true;
        $alertMessage = "OLVIDASTE CREAR UN ADMINISTRADOR, ¡CREALO!";
        $alertIcon = "info";
        $alertRedirect = "../ADMINISTRADOR/AGREGAR_ADMINISTRADOR/";
            }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alerta</title>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>

<body>

    <?php if (isset($showAlert) && $showAlert) : ?>
        <script type="text/javascript">
            swal({
                text: "<?php echo $alertMessage; ?>",
                icon: "<?php echo $alertIcon; ?>"
            }).then(function() {
                window.location.href = "<?php echo $alertRedirect; ?>";
            });
        </script>
    <?php endif; ?>

</body>

</html>

