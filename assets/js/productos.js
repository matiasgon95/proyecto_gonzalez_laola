/**
 * Script para manejar la funcionalidad de ordenamiento de productos
 */

// Función para cambiar el orden de los productos automáticamente cuando se selecciona una opción
function initProductSorting() {
    // Obtener el selector de ordenamiento
    const ordenSelector = document.getElementById('ordenSelector');
    
    // Si no existe el elemento, no ejecutar el código
    if (!ordenSelector) return;
    
    // Agregar evento change al selector
    ordenSelector.addEventListener('change', function() {
        // Obtener la URL seleccionada
        const url = this.value;
        
        // Redirigir a la URL seleccionada
        window.location.href = url;
    });
}

// Inicializar cuando el DOM esté cargado
document.addEventListener('DOMContentLoaded', function() {
    initProductSorting();
});

/**
 * Muestra un modal con la imagen ampliada del producto
 * @param {string} imagenSrc - URL de la imagen a mostrar
 * @param {string} nombreProducto - Nombre del producto para el título
 */
function mostrarImagenModal(imagenSrc, nombreProducto) {
    document.getElementById('imagenModalSrc').src = imagenSrc;
    document.getElementById('imagenModalLabel').textContent = 'Imagen: ' + nombreProducto;
    var modal = new bootstrap.Modal(document.getElementById('imagenModal'));
    modal.show();
}