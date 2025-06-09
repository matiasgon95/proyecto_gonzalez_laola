/**
 * Script para el autocompletado de la barra de búsqueda
 */
document.addEventListener('DOMContentLoaded', function() {
    // Seleccionar todos los campos de búsqueda con autocompletado
    const searchInputs = document.querySelectorAll('.search-autocomplete');
    
    searchInputs.forEach(input => {
        const resultsContainer = input.parentElement.querySelector('.autocomplete-results');
        let debounceTimer;
        
        // Evento de entrada de texto
        input.addEventListener('input', function() {
            const query = this.value.trim();
            
            // Limpiar el temporizador anterior
            clearTimeout(debounceTimer);
            
            // No buscar si la consulta está vacía
            if (query.length < 2) {
                resultsContainer.style.display = 'none';
                return;
            }
            
            // Establecer un temporizador para evitar demasiadas solicitudes
            debounceTimer = setTimeout(() => {
                fetch(`${baseUrl}/producto/sugerencias?q=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        // Limpiar resultados anteriores
                        resultsContainer.innerHTML = '';
                        
                        if (data.length === 0) {
                            resultsContainer.style.display = 'none';
                            return;
                        }
                        
                        // Crear elementos para cada sugerencia
                        data.forEach(producto => {
                            const item = document.createElement('div');
                            item.className = 'autocomplete-item';
                            
                            // Agregar imagen en miniatura si está disponible
                            if (producto.imagen) {
                                const img = document.createElement('img');
                                // Corregir la ruta de la imagen
                                img.src = `${baseUrl}/public/uploads/${producto.imagen}`;
                                img.alt = producto.nombre;
                                img.onerror = function() {
                                    // Si la imagen no se carga, mostrar una imagen de reemplazo
                                    this.src = `${baseUrl}/assets/img/logo.png`;
                                };
                                item.appendChild(img);
                            } else {
                                // Si no hay imagen, mostrar una imagen predeterminada
                                const img = document.createElement('img');
                                img.src = `${baseUrl}/assets/img/logo.png`;
                                img.alt = 'Sin imagen';
                                item.appendChild(img);
                            }
                            
                            // Contenedor para texto
                            const textContainer = document.createElement('div');
                            textContainer.style.flex = '1';
                            
                            // Nombre del producto
                            const nombre = document.createElement('div');
                            nombre.textContent = producto.nombre;
                            textContainer.appendChild(nombre);
                            
                            // Precio del producto
                            const precio = document.createElement('div');
                            precio.textContent = `$${parseFloat(producto.precio).toLocaleString('es-AR')}`;
                            textContainer.appendChild(precio);
                            
                            item.appendChild(textContainer);
                            
                            // Evento de clic para ir al detalle del producto
                            item.addEventListener('click', () => {
                                window.location.href = `${baseUrl}/producto/detalle/${producto.id}`;
                            });
                            
                            resultsContainer.appendChild(item);
                        });
                        
                        // Mostrar resultados
                        resultsContainer.style.display = 'block';
                    })
                    .catch(error => {
                        console.error('Error en autocompletado:', error);
                        resultsContainer.style.display = 'none';
                    });
            }, 300); // 300ms de retraso
        });
        
        // Ocultar resultados al hacer clic fuera
        document.addEventListener('click', function(e) {
            if (!input.contains(e.target) && !resultsContainer.contains(e.target)) {
                resultsContainer.style.display = 'none';
            }
        });
        
        // Ocultar resultados al presionar Escape
        input.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                resultsContainer.style.display = 'none';
            }
        });
    });
});