// modal.js

// Obtener los elementos de las modales
const modal = document.getElementById("modalSuccess"); // Modal de éxito
const passwordModal = document.getElementById("passwordModal"); // Modal de error de contraseñas
const closeModalBtn = document.getElementById("closeModalBtn"); // Botón de cierre de la modal de éxito
const closeModalFooterBtn = document.getElementById("closeModalFooterBtn"); // Botón de cierre del pie de la modal de éxito
const closePasswordModalBtn = document.getElementById("closePasswordModalBtn"); // Botón de cierre de la modal de contraseñas
const closePasswordModalFooterBtn = document.getElementById("closePasswordModalFooterBtn"); // Botón de cierre del pie de la modal de contraseñas

// Función para cerrar la modal de éxito
const closeModal = () => {
    modal.style.display = "none"; // Ocultamos la modal de confirmación
};

// Función para cerrar la modal de error de contraseñas
const closePasswordModal = () => {
    passwordModal.style.display = "none"; // Ocultamos la modal de error de contraseñas
};

// Cerrar la modal de éxito cuando el botón de cerrar en el encabezado es clickeado
closeModalBtn.addEventListener("click", closeModal);

// Cerrar la modal de éxito cuando el botón de cerrar en el pie es clickeado
closeModalFooterBtn.addEventListener("click", closeModal);

// Cerrar la modal de contraseñas no coincidentes cuando el botón de cerrar en el encabezado es clickeado
closePasswordModalBtn.addEventListener("click", closePasswordModal);

// Cerrar la modal de contraseñas no coincidentes cuando el botón de cerrar en el pie es clickeado
closePasswordModalFooterBtn.addEventListener("click", closePasswordModal);

// Cerrar modal cuando se hace clic fuera de la modal de éxito (en el fondo)
window.addEventListener("click", (e) => {
    if (e.target === modal) {
        closeModal();
    }
});

// Cerrar modal cuando se hace clic fuera de la modal de error de contraseñas (en el fondo)
window.addEventListener("click", (e) => {
    if (e.target === passwordModal) {
        closePasswordModal();
    }
});
