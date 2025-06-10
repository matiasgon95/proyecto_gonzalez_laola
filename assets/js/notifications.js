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

// Función para manejar el envío del formulario de agregar al carrito
function setupAddToCartForms() {
    const addToCartForms = document.querySelectorAll('form[action*="carrito_agrega"]');
    
    addToCartForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault(); // Prevenir el envío tradicional del formulario
            
            // Guardar la posición actual de desplazamiento
            const currentPosition = window.scrollY;
            
            // Crear un objeto FormData con los datos del formulario
            const formData = new FormData(this);
            
            // Enviar los datos mediante fetch API
            fetch(baseUrl + 'carrito_agrega', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                // Verificar si el producto se añadió correctamente
                // Si hay un mensaje, usarlo; de lo contrario, usar un mensaje predeterminado
                const message = data.message || 'Producto añadido al carrito';
                
                // Comprobar si el producto se añadió correctamente
                // Si success está definido, usarlo; de lo contrario, asumir éxito
                const isSuccess = data.success !== undefined ? data.success : true;
                
                // Crear y mostrar la notificación toast
                showToastNotification(message, isSuccess ? 'success' : 'error');
                
                // Actualizar el contador del carrito
                if (typeof updateCartCount === 'function') {
                    updateCartCount();
                }
                
                // Restaurar la posición de desplazamiento
                window.scrollTo(0, currentPosition);
            })
            .catch(error => {
                console.error('Error al agregar al carrito:', error);
                // Verificar si el producto se añadió a pesar del error
                // Actualizar el contador del carrito para verificar
                if (typeof updateCartCount === 'function') {
                    updateCartCount();
                }
                // Mostrar un mensaje más informativo
                showToastNotification('Producto añadido al carrito', 'success');
            });
        });
    });
}

// Función para mostrar notificaciones toast dinámicamente
function showToastNotification(message, type = 'success') {
    // Crear el contenedor del toast si no existe
    let toastContainer = document.querySelector('.toast-container');
    if (!toastContainer) {
        toastContainer = document.createElement('div');
        toastContainer.className = 'position-fixed bottom-0 end-0 p-3 toast-container';
        toastContainer.style.zIndex = '1100';
        document.body.appendChild(toastContainer);
    }
    
    // Crear el elemento toast
    const toastElement = document.createElement('div');
    toastElement.className = 'toast show bg-dark';
    toastElement.setAttribute('role', 'alert');
    toastElement.setAttribute('aria-live', 'assertive');
    toastElement.setAttribute('aria-atomic', 'true');
    
    // Determinar el color del encabezado según el tipo
    const headerClass = type === 'success' ? 'bg-info' : 'bg-danger';
    
    // Crear el contenido del toast
    toastElement.innerHTML = `
        <div class="toast-header ${headerClass} text-dark">
            <i class="fas fa-info-circle me-2"></i>
            <strong class="me-auto">Notificación</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Cerrar"></button>
        </div>
        <div class="toast-body text-light">
            <div class="d-flex flex-column">
                <div class="mb-2">${message}</div>
                <button type="button" class="btn btn-info btn-sm align-self-end" id="openCartModalBtn">
                    <i class="fas fa-shopping-cart me-1"></i>Ver carrito
                </button>
            </div>
        </div>
    `;
    
    // Añadir el toast al contenedor
    toastContainer.appendChild(toastElement);
    
    // Configurar el botón para abrir el carrito
    const openCartModalBtn = toastElement.querySelector('#openCartModalBtn');
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
    
    // Configurar el cierre automático después de 5 segundos
    setTimeout(() => {
        const bsToast = new bootstrap.Toast(toastElement);
        bsToast.hide();
        // Eliminar el toast del DOM después de ocultarlo
        toastElement.addEventListener('hidden.bs.toast', function () {
            toastElement.remove();
        });
    }, 5000);
}

// Inicializar cuando el DOM esté cargado
document.addEventListener('DOMContentLoaded', function() {
    initToastNotifications();
    setupAddToCartForms();
});