<?php
session_start();
include "../BD.php";

$correo = $_POST['correo'];
$pass = $_POST['pass'];

$sql = "SELECT Contrasena, id_tipo FROM login_usuarios WHERE Correo = ?";
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
            header('location: ../ADMINISTRADOR/');
            break;
        case 2:
            header('location: ../PROFESORES/');
            break;
        case 3:
            header('location: ../ALUMNOS/');
            break;
        default:
            header('location: ../');
            break;
    }
}
echo '<script>alert("Correo y/o contraseña incorrecta");window.location= "../";</script>';