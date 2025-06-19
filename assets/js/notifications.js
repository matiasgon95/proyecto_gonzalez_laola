/**
 * @fileoverview Sistema de notificaciones toast y funcionalidad del carrito de compras
 * Este script maneja la creación y visualización de notificaciones toast para informar
 * al usuario sobre acciones relacionadas con el carrito de compras, así como la
 * funcionalidad para agregar productos al carrito mediante AJAX.
 */

/**
 * Inicializa las notificaciones toast y configura el botón para abrir el modal del carrito
 * - Configura el cierre automático de los toast después de 5 segundos
 * - Mantiene la posición de desplazamiento de la página después de mostrar notificaciones
 * - Configura el evento para abrir el modal del carrito desde el botón del toast
 */
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

/**
 * Configura los formularios de agregar al carrito para usar AJAX en lugar de envío tradicional
 * - Previene el envío tradicional del formulario
 * - Envía los datos mediante fetch API
 * - Muestra notificaciones toast con el resultado
 * - Actualiza el contador del carrito
 * - Mantiene la posición de desplazamiento de la página
 */
function setupAddToCartForms() {
    const addToCartForms = document.querySelectorAll('form[action*="carrito_agrega"]');
    
    addToCartForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const cantidadInput = form.querySelector('input[name="qty"]');
            
            // Verificar si existe el campo de cantidad
            if (cantidadInput) {
                const maxStock = parseInt(cantidadInput.getAttribute('max'), 10);
                const cantidad = parseInt(cantidadInput.value, 10);
                if (cantidad > maxStock) {
                    showToastNotification('No hay suficiente stock disponible para la cantidad solicitada.', 'error');
                    return;
                }
            }
            
            // Guardar la posición actual de desplazamiento
            const currentPosition = window.scrollY;
            
            // Crear un objeto FormData con los datos del formulario
            const formData = new FormData(this);
            
            // Si no existe el campo qty, agregar un valor predeterminado de 1
            if (!cantidadInput) {
                formData.append('qty', '1');
            }
            
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

/**
 * Crea y muestra notificaciones toast dinámicamente
 * @param {string} message - El mensaje a mostrar en la notificación
 * @param {string} type - El tipo de notificación ('success' o 'error')
 * 
 * Esta función:
 * - Crea un contenedor para los toast si no existe
 * - Genera dinámicamente el HTML para la notificación
 * - Configura el botón para ver el carrito
 * - Establece un temporizador para cerrar automáticamente la notificación
 * - Elimina el elemento del DOM después de ocultarlo
 */
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