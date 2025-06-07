/**
 * Script para manejar las notificaciones toast y la funcionalidad del carrito
 */

// Función para inicializar las notificaciones toast
function initToastNotifications() {
    // Guardar la posición actual de la página
    const currentPosition = window.scrollY;
    
    // Configurar el toast para que se cierre automáticamente después de 5 segundos
    setTimeout(function() {
        const toast = document.querySelector('.toast');
        if (toast) {
            const bsToast = new bootstrap.Toast(toast);
            bsToast.hide();
        }
    }, 5000);
    
    // Restaurar la posición de desplazamiento
    window.scrollTo(0, currentPosition);
    
    // Abrir el modal del carrito al hacer clic en el botón del toast
    const openCartModalBtn = document.getElementById('openCartModalBtn');
    if (openCartModalBtn) {
        openCartModalBtn.addEventListener('click', function() {
            const cartModal = document.getElementById('cartModal');
            if (cartModal) {
                cartModal.classList.add('show');
                // Cargar el contenido del carrito
                fetch(baseUrl + 'carrito/mini')
                    .then(response => response.text())
                    .then(data => {
                        const cartModalBody = document.getElementById('cartModalBody');
                        if (cartModalBody) {
                            cartModalBody.innerHTML = data;
                            // Configurar los botones del carrito
                            if (typeof window.setupCartButtons === 'function') {
                                window.setupCartButtons();
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error al cargar el carrito:', error);
                    });
            }
        });
    }
}

// Inicializar cuando el DOM esté cargado
document.addEventListener('DOMContentLoaded', function() {
    initToastNotifications();
});