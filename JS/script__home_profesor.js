// Array de URLs de las imágenes

//aca es donde vamos a referencias las paginas para cargar los grupos, sisi usted si le sabe
var images = [
    {src: "../imagenes/recurso_profesor_1.jpg", href: "pagina_imagen1.html"},
    {src: "../imagenes/recurso_profesor_2.jpg", href: "pagina_imagen2.html"},
    {src: "../imagenes/recurso_profesor_3.jpg", href: "pagina_imagen3.html"},
    {src: "../imagenes/recurso_profesor_4.jpg", href: "pagina_imagen4.html"},
    {src: "../imagenes/recurso_profesor_5.jpg", href: "pagina_imagen5.html"},
    {src: "../imagenes/recurso_profesor_6.jpg", href: "pagina_imagen6.html"}
];

// Variable para almacenar la posición de la imagen actual
var currentIndex = 0;

// Función para cambiar la imagen con transición
function cambiarImagen(n) {
    currentIndex = (currentIndex + n + images.length) % images.length;
    var image = document.getElementById("current-image");
    var previousImageOverlay = document.getElementById("previous-image-overlay");
    var nextImageOverlay = document.getElementById("next-image-overlay");

    image.style.opacity = 0;
    previousImageOverlay.style.opacity = 0;
    nextImageOverlay.style.opacity = 0;

    setTimeout(function() {
        image.src = images[currentIndex].src;
        image.parentElement.href = images[currentIndex].href;
        image.style.opacity = 1;

        var previousIndex = (currentIndex - 1 + images.length) % images.length;
        var nextIndex = (currentIndex + 1) % images.length;

        previousImageOverlay.style.backgroundImage = "url('" + images[previousIndex].src + "')";
        previousImageOverlay.parentElement.href = images[previousIndex].href;
        nextImageOverlay.style.backgroundImage = "url('" + images[nextIndex].src + "')";
        nextImageOverlay.parentElement.href = images[nextIndex].href;

        previousImageOverlay.style.opacity = 0.5;
        nextImageOverlay.style.opacity = 0.5;
    }, 500); // La transición toma 0.5 segundos (500 milisegundos)
}

// Mostrar la primera imagen al cargar la página
window.onload = function () {
    document.getElementById("current-image").src = images[currentIndex].src;
};
