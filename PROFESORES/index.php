<?php
include "../BD.php";
session_start();
$correo = $_SESSION['correo'];
// Realizar la consulta para obtener el nombre
$sql = "select nombres, apellido_paterno, apellido_materno from profesores where correo = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $correo);
$stmt->execute();
$result = $stmt->get_result();

// Verificar si se encontraron resultados
if ($result->num_rows > 0) {
    // Obtener el nombre de la fila
    $fila = $result->fetch_assoc();
    $nombre = $fila["nombres"];
    $ap_pa = $fila["apellido_paterno"];
    $ap_ma = $fila["apellido_materno"];
} else {
    $nombre = "Nombre no encontrado";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>profesores</title>
  <link rel="stylesheet" href="../estilos/style_home_profesor.css">
</head>
<body>
  
<h1 class="titulo-bienvenida">Bienvenido(a): <?php echo $nombre . ' ' . $ap_pa . ' ' . $ap_ma; ?></h1>

<div class="boton-redondo">
  <a href="actualizacion_datos.php">
    <img class="imagen" src="https://www.eraeidon.com/eidon/wp-content/uploads/2016/12/usuario-masculino-foto-de-perfil_318-37825.jpg" alt="Botón Redondo">
  </a>
</div>
<h2 class="button-description1">Información personal</h2>
<br>
<div class="boton-redondo2" onclick="alert('Haz hecho clic en el botón')">
  <a href="pagina_imagen2.html">
    <img class="imagen" src="https://static.vecteezy.com/system/resources/previews/017/435/027/original/calendar-icon-in-flat-style-agenda-illustration-on-black-round-background-with-long-shadow-effect-schedule-planner-circle-button-business-concept-vector.jpg" alt="Botón Redondo2">
  </a>
</div>
<h2 class="button-description2">Calendario</h2>

<div class="boton-redondo3">
  <a href="../CONTROLADORES/cerrar_sesion.php" onclick="return confirm('¿Seguro que deseas cerrar sesión?')">
    <img class="imagen" src="../imagenes/cerrar_sesion_icono.png" alt="Botón Redondo3">
    
  </a>
</div>
<h2 class="button-description3">Cerrar sesión</h2>

<div id="image-gallery">
    <div id="current-image-container">
        <a href="#" onclick="return false;"><img id="current-image" src="https://via.placeholder.com/600x400" alt="Imagen 1"></a>
        <div id="previous-image-overlay" class="image-overlay"></div>
        <div id="next-image-overlay" class="image-overlay"></div>
    </div>

    <br>
    <button class="button" onclick="cambiarImagen(-1)">Anterior</button>
    <button class="button" onclick="cambiarImagen(1)">Siguiente</button>
    
</div>
<script src="../JS/script__home_profesor.js"></script>

</body>
</html>
