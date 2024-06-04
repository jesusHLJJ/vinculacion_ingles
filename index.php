<?php
session_start();

if (isset($_SESSION['tipo'])) {
    switch ($_SESSION['tipo']) {
        case 1: // Tutor
            header('location: ADMINISTRADOR/');
            break;
            case 2: // Administrador
                header('location: PROFESORES/');
            break;
        case 3: // Alumno

            header('location: ALUMNOS/alumnos.php');
            break;
        default:
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="estilos/style_login.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>

    <header>
        
    </header>

    <div class="wrapper">
        <form action="CONTROLADORES/validar_log.php" method="post">
            <h1>INICIAR SESIÓN</h1>

            <div class="input-box">
                <input type="email" id="correo" name="correo" placeholder="CORREO ELECTRONICO" required>
                <i class='bx bxs-user'></i>
            </div>

            <div class="input-box">
                <input type="password" id="pass" name="pass" placeholder="CONTRASEÑA" required>
                <i class='bx bxs-lock-alt'></i>
            </div>
           
            <button type="submit" class="btn">ENTRAR</button>
            <br><br>
            
            <div class="olvide-c">
                <a href="registros.php">REGISTRARSE</a>
            </div>
        </form>
    </div>
    <?php
    include "BD.php";
    ?>
</body>
</html>