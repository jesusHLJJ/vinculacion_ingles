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
<nav class="navbar">
    <ul>
        <li>
          <br>
            <a class="principal" href="actualizacion_datos.php">
                <img class="small-image" src="../imagenes/icono_profesor.jpg" alt="">
                <span class="nav-item">Información personal</span>
            </a>
        </li>
        <li>
            <a href="https://tesi.org.mx/tesi.org.mx/vinculos/oferta_educativa/calendario_escolar/CALENDARIO%20ESCOLAR%202023-2024.pdf" target="_blank">
                <img class="small-image" src="https://static.vecteezy.com/system/resources/previews/017/435/027/original/calendar-icon-in-flat-style-agenda-illustration-on-black-round-background-with-long-shadow-effect-schedule-planner-circle-button-business-concept-vector.jpg" alt="">
                <span class="nav-item">Calendario</span>
            </a>
        </li>
        <li>
            <a class="logout" id="cerrar" href="#">
                <img class="small-image" src="../imagenes/cerrar_sesion_icono.png" alt="">
                <span class="nav-item">Cerrar sesión</span>
            </a>
        </li>
    </ul>
</nav>

<div class="container">
    <div class="icono-izquierdo">
        <img src="../imagenes/icon_prof.png" alt="Icono">
    </div>
    <div class="icono-derecho">
        <img src="../imagenes/icon_prof.png" alt="Icono">
    </div>

    <h1 class="titulo-bienvenida">Bienvenido(a): <?php echo $nombre . ' ' . $ap_pa . ' ' . $ap_ma; ?></h1>

    <div id="image-gallery">
        <a href="../PROFESORES/show_g1.php"><img src="../imagenes/recurso_profesor_1.jpg" alt="Imagen 1"></a>
        <a href="../PROFESORES/show_g2.php"><img src="../imagenes/recurso_profesor_22.jpg" alt="Imagen 2"></a>
        <a href="../PROFESORES/show_g3.php"><img src="../imagenes/recurso_profesor_33.jpg" alt="Imagen 3"></a>
        <a href="../PROFESORES/show_g4.php"><img src="../imagenes/recurso_profesor_4.jpg" alt="Imagen 4"></a>
        <a href="../PROFESORES/show_g5.php"><img src="../imagenes/recurso_profesor_5.jpg" alt="Imagen 5"></a>
        <a href="../PROFESORES/show_g6.php"><img src="../imagenes/recurso_profesor_6.jpg" alt="Imagen 6"></a>
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
