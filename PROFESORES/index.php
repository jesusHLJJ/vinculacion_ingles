<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Botón Redondo</title>
  <link rel="stylesheet" href="../estilos/style_home_profesor.css">
</head>
<body>

<div class="boton-redondo" onclick="alert('Haz hecho clic en el botón')">
  <a href="pagina_imagen1.html">
    <img class="imagen" src="https://www.eraeidon.com/eidon/wp-content/uploads/2016/12/usuario-masculino-foto-de-perfil_318-37825.jpg" alt="Botón Redondo">
  </a>
</div>
<br>
<div class="boton-redondo2" onclick="alert('Haz hecho clic en el botón')">
  <a href="pagina_imagen2.html">
    <img class="imagen" src="https://static.vecteezy.com/system/resources/previews/017/435/027/original/calendar-icon-in-flat-style-agenda-illustration-on-black-round-background-with-long-shadow-effect-schedule-planner-circle-button-business-concept-vector.jpg" alt="Botón Redondo2">
  </a>
</div>

<div class="boton-redondo3">
  <a href="../CONTROLADORES/cerrar_sesion.php" onclick="return confirm('¿Seguro que deseas cerrar sesión?')">
    <img class="imagen" src="../imagenes/cerrar_sesion_icono.png" alt="Botón Redondo3">
  </a>
</div>

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

