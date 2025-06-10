document.addEventListener('DOMContentLoaded', function() {
    // Verificar el estado de los favoritos al cargar la página
    verificarFavoritos();
    
    // Configurar los botones de favoritos para usar AJAX
    configurarBotonesFavoritos();
});

// Función para verificar si los productos son favoritos
function verificarFavoritos() {
    // Obtener todos los botones de favoritos
    const botonesFavoritos = document.querySelectorAll('.favorito-btn');
    
    // Si no hay botones, salir de la función
    if (botonesFavoritos.length === 0) return;
    
    // Para cada botón, verificar si el producto es favorito
    botonesFavoritos.forEach(boton => {
        const productoId = boton.closest('form').querySelector('input[name="producto_id"]').value;
        
        // Hacer una petición AJAX para verificar si es favorito
        fetch(`/proyecto_gonzalez_laola/front/cliente/es_favorito/${productoId}`)
            .then(response => response.json())
            .then(data => {
                if (data.esFavorito) {
                    // Si es favorito, aplicar la clase activa
                    boton.classList.add('favorito-activo');
                } else {
                    // Si no es favorito, quitar la clase activa
                    boton.classList.remove('favorito-activo');
                }
            })
            .catch(error => console.error('Error al verificar favorito:', error));
    });
}

// Función para configurar los botones de favoritos para usar AJAX
function configurarBotonesFavoritos() {
    // Obtener todos los formularios de favoritos
    const formulariosFavoritos = document.querySelectorAll('form[action*="agregar_favorito"]');
    
    // Si no hay formularios, salir de la función
    if (formulariosFavoritos.length === 0) return;
    
    // Para cada formulario, configurar el evento submit
    formulariosFavoritos.forEach(formulario => {
        formulario.addEventListener('submit', function(event) {
            // Prevenir el envío normal del formulario
            event.preventDefault();
            
            // Obtener el botón y el ID del producto
            const boton = formulario.querySelector('button');
            const productoId = formulario.querySelector('input[name="producto_id"]').value;
            
            // Verificar si el producto ya es favorito
            fetch(`/proyecto_gonzalez_laola/front/cliente/es_favorito/${productoId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.esFavorito) {
                        // Si ya es favorito, eliminarlo
                        return fetch(`/proyecto_gonzalez_laola/front/cliente/eliminar_favorito/${productoId}`, {
                            method: 'GET'
                        });
                    } else {
                        // Si no es favorito, agregarlo
                        const formData = new FormData(formulario);
                        return fetch('/proyecto_gonzalez_laola/front/cliente/agregar_favorito', {
                            method: 'POST',
                            body: formData
                        });
                    }
                })
                .then(() => {
                    // Después de agregar/eliminar, verificar el nuevo estado
                    return fetch(`/proyecto_gonzalez_laola/front/cliente/es_favorito/${productoId}`);
                })
                .then(response => response.json())
                .then(data => {
                    // Actualizar la apariencia del botón según el nuevo estado
                    if (data.esFavorito) {
                        boton.classList.add('favorito-activo');
                    } else {
                        boton.classList.remove('favorito-activo');
                    }
                })
                .catch(error => console.error('Error al gestionar favorito:', error));
        });
    });
}