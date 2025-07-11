<?php
session_start();
include "BD.php";

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
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>

<body>
    <?php
    $sql = "SELECT correo FROM usuarios where id_tipo=1";
    $stmt = $conexion->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    // Verificar si se encontraron resultados
    if ($result->num_rows == 0) {
        $sql = "insert into usuarios (correo,contrasena,id_tipo) values ('admin@admin.com','$2y$10$9bGbJ98YlxsXsZ0rGVPsMuLGdPSM6ESMqX8JRCCpf/ojKo7Q1DNlG',1)";
        $result = $conexion->query($sql);
        if ($result) {
            echo '<script type="text/javascript">
            swal({
                text: "CREDENCIALES DE ACCESO DE USO ÚNICO \nCORREO: admin@admin.com \nCONTRASEÑA: admin",
                icon: "info"
            });
        </script>';
        }
    } else {
        $sql = "select correo from usuarios where correo='admin@admin.com' and id_tipo=1";
        $stmt = $conexion->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        //Verificar si se encontraron resultados
        if ($result->num_rows > 0) {
            $fila = $result->fetch_assoc();
            $correo_verificacion = $fila['correo'];
            echo '<script type="text/javascript">
            swal({
                text: "CREDENCIALES DE ACCESO DE USO ÚNICO \nCORREO: admin@admin.com \nCONTRASEÑA: admin",
                icon: "info"
            });
        </script>';
        }
    }
    ?>
    <header class="encabezado">
        <h2>Sistema de Administración del Departamento de Inglés (SADI)</h2>
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