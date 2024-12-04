const images = document.querySelectorAll('.container-image img');
let currentIndex = 0;

function showNextImage() {
    // Oculta la imagen actual
    images[currentIndex].style.opacity = 0;

    // Actualiza el índice
    currentIndex = (currentIndex + 1) % images.length;

    // Muestra la siguiente imagen
    images[currentIndex].style.opacity = 1;
}

// Muestra la primera imagen
images[currentIndex].style.opacity = 1;

// Cambia de imagen cada 5 segundos
setInterval(showNextImage, 20000);


