/**
 * Módulo de búsqueda y autocompletado
 * 
 * Este archivo implementa la funcionalidad de búsqueda con autocompletado para productos
 * y la gestión del buscador en dispositivos móviles.
 */

/**
 * Inicialización del autocompletado para campos de búsqueda
 * Configura la funcionalidad de autocompletado para todos los campos con clase 'search-autocomplete'
 */
document.addEventListener('DOMContentLoaded', function() {
    // Seleccionar todos los campos de búsqueda con autocompletado
    const searchInputs = document.querySelectorAll('.search-autocomplete');
    
    searchInputs.forEach(input => {
        const resultsContainer = input.parentElement.querySelector('.autocomplete-results');
        let debounceTimer;
        
        /**
         * Carga sugerencias de productos desde el servidor
         * @param {string} query - Texto de búsqueda (opcional)
         */
        function cargarSugerencias(query = '') {
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
                            // Construir la URL completa para la imagen
                            const imagenUrl = `${baseUrl}/public/${producto.imagen}`;
                            
                            // Asignar la imagen directamente
                            img.src = imagenUrl;
                            img.alt = producto.nombre;
                            img.onerror = function() {
                                console.log('Error al cargar la imagen:', this.src);
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
                        
                        // Precio del producto formateado con separadores de miles y decimales
                        const precio = document.createElement('div');
                        precio.textContent = `$${parseFloat(producto.precio).toLocaleString('es-AR', {minimumFractionDigits: 2, maximumFractionDigits: 2, useGrouping: true, decimal: ',', thousands: '.'})}`;  
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
        }
        
        // Evento de clic en el campo de búsqueda - muestra todas las sugerencias
        input.addEventListener('click', function() {
            // Cargar todas las sugerencias al hacer clic
            cargarSugerencias();
        });
        
        // Evento de entrada de texto con debounce para evitar múltiples solicitudes
        input.addEventListener('input', function() {
            const query = this.value.trim();
            
            // Limpiar el temporizador anterior
            clearTimeout(debounceTimer);
            
            // Si la consulta está vacía, mostrar todas las sugerencias
            if (query.length === 0) {
                cargarSugerencias();
                return;
            }
            
            // Establecer un temporizador para evitar demasiadas solicitudes
            debounceTimer = setTimeout(() => {
                cargarSugerencias(query);
            }, 300); // 300ms de retraso
        });
        
        // Ocultar resultados al hacer clic fuera del campo de búsqueda
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

/**
 * Funcionalidad para el botón de búsqueda en dispositivos móviles
 * Permite mostrar/ocultar el campo de búsqueda en interfaces móviles
 */
document.addEventListener('DOMContentLoaded', function() {
    const searchToggleBtn = document.getElementById('searchToggleBtn');
    const mobileSearchContainer = document.getElementById('mobileSearchContainer');
    const closeSearchBtn = document.getElementById('closeSearchBtn');
    
    if (searchToggleBtn && mobileSearchContainer) {
        // Mostrar el buscador móvil al hacer clic en el botón de lupa
        searchToggleBtn.addEventListener('click', function(e) {
            e.preventDefault();
            mobileSearchContainer.classList.remove('d-none');
            mobileSearchContainer.classList.add('d-block');
            // Enfocar el campo de búsqueda
            const searchInput = mobileSearchContainer.querySelector('.search-autocomplete');
            if (searchInput) {
                searchInput.focus();
            }
        });
        
        // Cerrar el buscador móvil al hacer clic en el botón de cerrar
        if (closeSearchBtn) {
            closeSearchBtn.addEventListener('click', function() {
                mobileSearchContainer.classList.remove('d-block');
                mobileSearchContainer.classList.add('d-none');
            });
        }
        
        // Cerrar el buscador móvil al hacer clic fuera de él
        document.addEventListener('click', function(e) {
            if (!mobileSearchContainer.contains(e.target) && 
                e.target !== searchToggleBtn && 
                !searchToggleBtn.contains(e.target) &&
                mobileSearchContainer.classList.contains('d-block')) {
                mobileSearchContainer.classList.remove('d-block');
                mobileSearchContainer.classList.add('d-none');
            }
        });
    }
});