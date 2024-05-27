// Array de URLs de las imágenes
var images = [
    {src: "../imagenes/recurso_profesor_1.jpg", href: "../PROFESORES/show_g1.php"},
    {src: "../imagenes/recurso_profesor_22.jpg", href: "../PROFESORES/show_g2.php"},
    {src: "../imagenes/recurso_profesor_33.jpg", href: "../PROFESORES/show_g3.php"},
    {src: "../imagenes/recurso_profesor_4.jpg", href: "../PROFESORES/show_g4.php"},
    {src: "../imagenes/recurso_profesor_5.jpg", href: "../PROFESORES/show_g5.php"},
    {src: "../imagenes/recurso_profesor_6.jpg", href: "../PROFESORES/show_g6.php"}
];

// Variable para almacenar la posición de la imagen actual
var currentIndex = 0;

// Función para cambiar la imagen con transición
function cambiarImagen(n) {
    currentIndex = (currentIndex + n + images.length) % images.length;
    var image = document.getElementById("current-image");
    var currentImageLink = document.getElementById("current-image-link");
    var previousImageOverlay = document.getElementById("previous-image-overlay");
    var nextImageOverlay = document.getElementById("next-image-overlay");

    image.style.opacity = 0;
    previousImageOverlay.style.opacity = 0;
    nextImageOverlay.style.opacity = 0;

    setTimeout(function() {
        image.src = images[currentIndex].src;
        currentImageLink.href = images[currentIndex].href;
        image.style.opacity = 1;

        var previousIndex = (currentIndex - 1 + images.length) % images.length;
        var nextIndex = (currentIndex + 1) % images.length;

        previousImageOverlay.style.backgroundImage = "url('" + images[previousIndex].src + "')";
        previousImageOverlay.style.cursor = "pointer";
        previousImageOverlay.onclick = function() { window.location.href = images[previousIndex].href; };
        nextImageOverlay.style.backgroundImage = "url('" + images[nextIndex].src + "')";
        nextImageOverlay.style.cursor = "pointer";
        nextImageOverlay.onclick = function() { window.location.href = images[nextIndex].href; };

        previousImageOverlay.style.opacity = 0.5;
        nextImageOverlay.style.opacity = 0.5;
    }, 500); // La transición toma 0.5 segundos (500 milisegundos)
}

// Mostrar la primera imagen al cargar la página
window.onload = function () {
    document.getElementById("current-image").src = images[currentIndex].src;
};
