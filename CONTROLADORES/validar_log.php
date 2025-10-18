<?php
session_start();
include "../BD.php";
include "../config.php"; 
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
            if($correo=='admin@admin.com'){
                $mensaje = "ESTA CUENTA SERÁ ELIMINADA UNA VEZ SE CREE A UN ADMINISTRADOR, FAVOR DE CREAR UN ADMINISTRADOR";
                $pagina = "../ADMINISTRADOR/AGREGAR_ADMINISTRADOR/";
            }else{
                $mensaje = "Inicio de sesión exitoso como administrador";
                $pagina = "../ADMINISTRADOR/";
            }
          
            break;
        case 2:
                if($control_sistema != 0){
                    $mensaje = "Inicio de sesión exitoso como profesor";
                    $pagina = "../PROFESORES/";
            }else{
                $mensaje = "Lo sentimos, el sistema fue cerrado temporalmente por un administrador";
                $pagina = "../";
                /*
                session_unset();
                session_destroy();*/
                
            }
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
    const control = <?php echo (int)$control_sistema; ?>;
    const tipoUsuario = <?php echo (int)$_SESSION['tipo']; ?>;
    const mensaje = "<?php echo $mensaje; ?>";
    const pagina = "<?php echo $pagina; ?>";

    // Si es admin (tipo 1), siempre success
    // Si no es admin y control == 0 → error
    const icono = (tipoUsuario === 1 || control === 1) ? "success" : "error";
    const titulo = (icono === "success") ? "¡Acceso concedido!" : "Acceso denegado";

    swal({
        title: titulo,
        text: mensaje,
        icon: icono,
        button: "Aceptar"
    }).then(function() {
        if (icono === "error") {
            // Llamar al PHP que destruye la sesión
            fetch('cerrar_sesion.php')
                .then(() => {
                    window.location.href = pagina;
                });
        } else {
            window.location.href = pagina;
        }
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
