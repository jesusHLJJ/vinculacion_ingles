<?php
include "../BD.php";
session_start();

if (!isset($_SESSION['tipo'])) {
    header('location: ../');
} else {
    if ($_SESSION['tipo'] != 2) {
        header('location: ../');
    }
}

$correo = $_SESSION['correo'];
// Realizar la consulta para obtener el nombre
$sql = "select profesores.id_profesor, profesores.nombre, profesores.ap_paterno, profesores.ap_materno, usuarios.correo from profesores JOIN usuarios on usuarios.id_usuario = profesores.id_usuario where usuarios.correo = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $correo);
$stmt->execute();
$result = $stmt->get_result();

// Verificar si se encontraron resultados
if ($result->num_rows > 0) {
    // Obtener el nombre de la fila
    $fila = $result->fetch_assoc();
    $_SESSION['id_profesor'] = $fila["id_profesor"];
    $nombre = $fila["nombre"];
    $_SESSION['nombre_profesor'] = $fila["nombre"];
    $ap_pa = $fila["ap_paterno"];
    $_SESSION['ap_1'] = $fila["ap_paterno"];
    $ap_ma = $fila["ap_materno"];
    $_SESSION['ap_2'] = $fila["ap_materno"];
} else {
    $nombre = "Nombre no encontrado";
}

$stmt->close();
$conexion->close();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>profesores</title>
    <link rel="stylesheet" href="../estilos/style_home_profesor.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>

    <div id="loader">
        <div class="loader-container">
            <div class="loader-spinner"></div>
            <div class="loader-image">
                <img src="../imagenes/si.jpg" alt="Loading">
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Simular una carga con un timeout (por ejemplo, una consulta a una API)
            setTimeout(function() {
                // Ocultar el cargador
                document.getElementById("loader").style.display = "none";
                // Mostrar el contenido
                document.getElementById("content").style.display = "block";
            }, 400); // Ajusta el tiempo según sea necesario
        });
    </script>

    <nav class="navbar navbar-dark" style="background-color: #1b396a;">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <img src="../imagenes/tecnm_logo.png" alt="TECNM Logo" class="img-fluid" style="height:40px;">
            <img src="../imagenes/tesi_logo.png" alt="TESI Logo" class="img-fluid" style="height:40px;">


            <a class="navbar-brand d-flex align-items-center me-3" href="actualizacion_datos.php">
                <img src="../imagenes/icono_profesor.jpg" alt="" class="rounded-circle me-2" style="width:40px; height:40px;">
                Información personal
            </a>

            <a class="navbar-brand d-flex align-items-center me-3" href="https://tesi.org.mx/tesi.org.mx/vinculos/oferta_educativa/calendario_escolar/CALENDARIO%20ESCOLAR%202023-2024.pdf" target="_blank">
                <img class="small-image" src="https://static.vecteezy.com/system/resources/previews/017/435/027/original/calendar-icon-in-flat-style-agenda-illustration-on-black-round-background-with-long-shadow-effect-schedule-planner-circle-button-business-concept-vector.jpg" alt="" style="width:40px; height:40px;">
                <span class="nav-item">Calendario</span>
            </a>

            <a class="navbar-brand d-flex align-items-center" id="cerrar" href="#">
                <img src="../imagenes/cerrar_sesion_icono.png" alt="" class="rounded-circle me-2" style="width:40px; height:40px;">
                Cerrar sesión
            </a>



            <h6 class="text-warning mb-0 text-center">
                <?php echo $nombre . ' ' . $ap_pa . ' ' . $ap_ma; ?>
            </h6>

        </div>
    </nav>


    <div class="custom-container">
        <div class="container mt-4">
            <div class="row g-4">

                <div class="col-sm-6 col-md-4 col-lg-2">
                    <div class="card">
                        <img src="../imagenes/recurso_profesor_1.jpg" class="card-img-top" alt="Imagen 1">
                        <div class="card-body">
                            <h5 class="card-title">NIVEL 1</h5>
                            <p class="card-text">Da click en "ver" para acceder a tus grupos disponibles de este nivel.</p>
                            <a href="../PROFESORES/show_g1.php" class="btn btn-primary">Ver</a>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-md-4 col-lg-2">
                    <div class="card">
                        <img src="../imagenes/recurso_profesor_22.jpg" class="card-img-top" alt="Imagen 2">
                        <div class="card-body">
                            <h5 class="card-title">NIVEL 2</h5>
                            <p class="card-text">Da click en "ver" para acceder a tus grupos disponibles de este nivel.</p>
                            <a href="../PROFESORES/show_g2.php" class="btn btn-primary">Ver</a>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-md-4 col-lg-2">
                    <div class="card">
                        <img src="../imagenes/recurso_profesor_33.jpg" class="card-img-top" alt="Imagen 3">
                        <div class="card-body">
                            <h5 class="card-title">NIVEL 3</h5>
                            <p class="card-text">Da click en "ver" para acceder a tus grupos disponibles de este nivel.</p>
                            <a href="../PROFESORES/show_g3.php" class="btn btn-primary">Ver</a>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-md-4 col-lg-2">
                    <div class="card">
                        <img src="../imagenes/recurso_profesor_4.jpg" class="card-img-top" alt="Imagen 4">
                        <div class="card-body">
                            <h5 class="card-title">NIVEL 4</h5>
                            <p class="card-text">Da click en "ver" para acceder a tus grupos disponibles de este nivel.</p>
                            <a href="../PROFESORES/show_g4.php" class="btn btn-primary">Ver</a>
                        </div>
                    </div>
                </div>

                <!-- Fila centrada para las últimas dos tarjetas -->
    
                    <!-- NIVEL 5 -->
                    <div class="col-sm-6 col-md-4 col-lg-2">
                        <div class="card">
                            <img src="../imagenes/recurso_profesor_5.jpg" class="card-img-top" alt="Imagen 5">
                            <div class="card-body text-center">
                                <h5 class="card-title">NIVEL 5</h5>
                                <p class="card-text">Da click en "ver" para acceder a tus grupos disponibles de este nivel.</p>
                                <a href="../PROFESORES/show_g5.php" class="btn btn-primary">Ver</a>
                            </div>
                        </div>
                    </div>

                    <!-- NIVEL 6 -->
                    <div class="col-sm-6 col-md-4 col-lg-2">
                        <div class="card">
                            <img src="../imagenes/recurso_profesor_6.jpg" class="card-img-top" alt="Imagen 6">
                            <div class="card-body text-center">
                                <h5 class="card-title">NIVEL 6</h5>
                                <p class="card-text">Da click en "ver" para acceder a tus grupos disponibles de este nivel.</p>
                                <a href="../PROFESORES/show_g6.php" class="btn btn-primary">Ver</a>
                            </div>
                        </div>
                    </div>
              

            </div>
        </div>

    </div>

    <script>
        document.getElementById("cerrar").addEventListener("click", function() {
            Swal.fire({
                title: '¿Deseas cerrar sesión?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, cerrar sesión'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "../CONTROLADORES/cerrar_sesion.php";
                }
            });
        });
    </script>
</body>

</html>