<?php
session_start();
include "../BD.php";

$correo = $_POST['correo'];
$pass = $_POST['pass'];

$sql = "SELECT contrasena, id_tipo FROM usuarios WHERE correo = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $correo);
$stmt->execute();
$stmt->bind_result($hash, $idtipo);
$stmt->fetch();
$stmt->close();

if (password_verify($pass, $hash)) {
    $_SESSION['correo'] = $correo;
    $_SESSION['tipo'] = $idtipo;
    switch ($idtipo) {
        case 1:
            $mensaje = "Inicio de sesión exitoso como administrador";
            $pagina = "../ADMINISTRADOR/";
            break;
        case 2:
            $mensaje = "Inicio de sesión exitoso como profesor";
            $pagina = "../PROFESORES/";
            break;
        case 3:
            $mensaje = "Inicio de sesión exitoso como alumno";
            header('location:../ALUMNOS/alumnos.php');
            break;
        default:
            $mensaje = "Inicio de sesión exitoso";
            $pagina = "../";
            break;
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Validar_log</title>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<body>
    <script type="text/javascript">
        swal({
            text: "<?php echo $mensaje; ?>",
            icon: "success"
        }).then(function() {
            window.location.href = "<?php echo $pagina; ?>";
        });
    </script>
</body>
</html>
<?php
} else {
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Validar_log</title>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<body>
    <script type="text/javascript">
        swal({
            text: "Correo y/o contraseña incorrecta",
            icon: "error"
        }).then(function() {
            window.location.href = "../";
        });
    </script>
</body>
</html>
<?php
}
?>
