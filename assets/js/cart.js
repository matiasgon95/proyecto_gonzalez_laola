document.addEventListener('DOMContentLoaded', function() {
    // Elementos del carrito modal
    const cartModal = document.getElementById('cartModal');
    const openCartBtn = document.getElementById('openCartModal');
    const closeCartBtn = document.getElementById('closeCartModal');
    const continueShoppingBtn = document.getElementById('continueShoppingBtn');
    const cartModalBody = document.getElementById('cartModalBody');
    const navCartBtn = document.querySelector('.nav-icon-link.position-relative');
    
    // Si no existen los elementos, no ejecutar el código
    if (!cartModal || !openCartBtn) return;
    
    // Función para cargar el contenido del carrito
    function loadCartContent() {
        fetch(baseUrl + 'carrito/mini')
            .then(response => response.text())
            .then(data => {
                cartModalBody.innerHTML = data;
                // Añadir event listeners a los botones después de cargar el contenido
                setupCartButtons();
            })
            .catch(error => {
                cartModalBody.innerHTML = '<div class="alert alert-danger">Error al cargar el carrito</div>';
                console.error('Error:', error);
            });
    }
    
    // Configurar los event listeners para los botones del carrito
    // Exponemos la función globalmente para que pueda ser llamada desde otros scripts
    window.setupCartButtons = function() {
        // Botones de suma
        document.querySelectorAll('.btn-cart-suma').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const rowid = this.getAttribute('data-rowid');
                updateCartItem(rowid, 'suma');
            });
        });
        
        // Botones de resta
        document.querySelectorAll('.btn-cart-resta').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const rowid = this.getAttribute('data-rowid');
                updateCartItem(rowid, 'resta');
            });
        });
        
        // Botones de eliminar
        document.querySelectorAll('.btn-cart-remove').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const rowid = this.getAttribute('data-rowid');
                updateCartItem(rowid, 'remove');
            });
        });
        
        // Botón de vaciar carrito
        const clearCartBtn = document.querySelector('.btn-cart-clear');
        if (clearCartBtn) {
            clearCartBtn.addEventListener('click', function(e) {
                e.preventDefault();
                if (confirm('¿Estás seguro de que deseas vaciar el carrito?')) {
                    fetch(baseUrl + 'carrito_vaciar')
                        .then(response => {
                            if (response.ok) {
                                loadCartContent();
                                updateCartCount();
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                }
            });
        }
        
        // Botón de finalizar compra
        const checkoutBtn = document.querySelector('.btn-cart-checkout');
        if (checkoutBtn) {
            checkoutBtn.addEventListener('click', function(e) {
                e.preventDefault();
                window.location.href = baseUrl + 'carrito';
            });
        }
    };
    
    // Función para actualizar un item del carrito
    function updateCartItem(rowid, action) {
        let url = '';
        switch(action) {
            case 'suma':
                url = baseUrl + 'carrito_suma/' + rowid;
                break;
            case 'resta':
                url = baseUrl + 'carrito_resta/' + rowid;
                break;
            case 'remove':
                if (confirm('¿Estás seguro de que deseas eliminar este producto del carrito?')) {
                    url = baseUrl + 'carrito_elimina/' + rowid;
                } else {
                    return; // Si el usuario cancela, no hacer nada
                }
                break;
        }
        
        fetch(url)
            .then(response => {
                if (response.ok) {
                    // Recargar el contenido del carrito
                    loadCartContent();
                    // Actualizar el contador del carrito en la navegación y el flotante
                    updateCartCount();
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }
    
    // Función para actualizar el contador del carrito
    function updateCartCount() {
        fetch(baseUrl + 'carrito/count')
            .then(response => response.json())
            .then(data => {
                // Actualizar contador en el botón flotante
                const floatingCartCount = document.querySelector('.floating-cart .cart-count');
                if (floatingCartCount) {
                    floatingCartCount.textContent = data.count;
                }
                
                // Actualizar contador en la barra de navegación
                const navCartCount = document.querySelector('.nav-icon-link .badge');
                if (navCartCount) {
                    navCartCount.textContent = data.count;
                }
                
                // Mostrar u ocultar el botón flotante según si hay items
                const floatingCartContainer = document.querySelector('.floating-cart-container');
                if (floatingCartContainer) {
                    if (data.count > 0) {
                        floatingCartContainer.style.display = 'block';
                    } else {
                        floatingCartContainer.style.display = 'none';
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }
    
    // Abrir modal
    openCartBtn.addEventListener('click', function(e) {
        e.preventDefault();
        cartModal.classList.add('show');
        loadCartContent();
    });
    
    // Modificar el comportamiento del botón del carrito en la barra de navegación
    if (navCartBtn) {
        navCartBtn.addEventListener('click', function(e) {
            e.preventDefault();
            cartModal.classList.add('show');
            loadCartContent();
        });
    }
    
    // Cerrar modal
    if (closeCartBtn) {
        closeCartBtn.addEventListener('click', function() {
            cartModal.classList.remove('show');
        });
    }
    
    if (continueShoppingBtn) {
        continueShoppingBtn.addEventListener('click', function() {
            cartModal.classList.remove('show');
        });
    }
    
    // Cerrar modal al hacer clic fuera del contenido
    window.addEventListener('click', function(event) {
        if (event.target === cartModal) {
            cartModal.classList.remove('show');
        }
    });
});