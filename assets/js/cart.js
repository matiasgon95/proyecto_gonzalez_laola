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

// Funcionalidad para el checkout
document.addEventListener('DOMContentLoaded', function() {
    // Verificar si estamos en la página de checkout
    if (!document.getElementById('checkout')) return;
    
    // Elementos del checkout
    const checkoutSteps = document.querySelectorAll('.checkout-step');
    const stepContents = document.querySelectorAll('.checkout-step-content');
    const nextStepBtn = document.getElementById('nextStepBtn');
    const prevStepBtn = document.getElementById('prevStepBtn');
    const submitBtn = document.getElementById('submitCheckoutBtn');
    let currentStep = 0;
    
    // Mostrar/ocultar campos de dirección según método de entrega
    const metodoEntrega = document.querySelectorAll('input[name="metodo_entrega"]');
    const datosEnvio = document.getElementById('datos_envio');
    const costoEnvioElement = document.getElementById('costo_envio');
    const inputCostoEnvio = document.querySelector('input[name="costo_envio"]');
    const totalFinalElement = document.getElementById('total_final');
    const inputTotal = document.querySelector('input[name="total"]');
    const subtotalValue = parseFloat(document.getElementById('subtotal_value').value);
    
    // Función para actualizar el paso actual
    function updateStep(newStep) {
        // Ocultar paso actual
        stepContents[currentStep].classList.remove('active');
        checkoutSteps[currentStep].classList.remove('active');
        
        // Actualizar paso actual
        currentStep = newStep;
        
        // Mostrar nuevo paso
        stepContents[currentStep].classList.add('active');
        checkoutSteps[currentStep].classList.add('active');
        
        // Actualizar estado de los botones
        prevStepBtn.style.display = currentStep > 0 ? 'block' : 'none';
        nextStepBtn.style.display = currentStep < stepContents.length - 1 ? 'block' : 'none';
        submitBtn.style.display = currentStep === stepContents.length - 1 ? 'block' : 'none';
        
        // Si es el paso de resumen, actualizar los datos
        if (currentStep === 1) {
            updateSummary();
        }
    }
    
    // Inicializar el primer paso
    if (checkoutSteps.length > 0 && stepContents.length > 0) {
        updateStep(0);
    }
    
    // Event listeners para los botones de navegación
    if (nextStepBtn) {
        nextStepBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Validar campos requeridos antes de avanzar
            if (currentStep === 0) {
                const isValid = validateRequiredFields();
                if (!isValid) return;
            }
            
            if (currentStep < stepContents.length - 1) {
                updateStep(currentStep + 1);
            }
        });
    }
    
    if (prevStepBtn) {
        prevStepBtn.addEventListener('click', function(e) {
            e.preventDefault();
            if (currentStep > 0) {
                updateStep(currentStep - 1);
            }
        });
    }
    
    // Función para validar campos requeridos
    function validateRequiredFields() {
        let isValid = true;
        const requiredFields = stepContents[currentStep].querySelectorAll('[required]');
        
        requiredFields.forEach(field => {
            field.classList.remove('is-invalid');
            if (!field.value.trim()) {
                field.classList.add('is-invalid');
                isValid = false;
            }
        });
        
        // Validar campos específicos según el método de entrega
        if (document.getElementById('envio_domicilio').checked) {
            const direccion = document.getElementById('direccion');
            const codigoPostal = document.getElementById('codigo_postal');
            
            if (!direccion.value.trim()) {
                direccion.classList.add('is-invalid');
                isValid = false;
            }
            
            if (!codigoPostal.value.trim()) {
                codigoPostal.classList.add('is-invalid');
                isValid = false;
            }
        }
        
        return isValid;
    }
    
    // Función para actualizar el resumen
    function updateSummary() {
        // Actualizar datos del cliente
        const nombreCompleto = document.getElementById('nombre').value;
        const email = document.getElementById('email').value;
        const telefono = document.getElementById('telefono').value;
        
        document.getElementById('summary_nombre').textContent = nombreCompleto;
        document.getElementById('summary_email').textContent = email;
        document.getElementById('summary_telefono').textContent = telefono || 'No proporcionado';
        
        // Actualizar método de entrega
        const metodoEntregaValue = document.querySelector('input[name="metodo_entrega"]:checked').value;
        const metodoEntregaText = metodoEntregaValue === 'retiro_local' ? 'Retiro en local' : 'Envío a domicilio';
        document.getElementById('summary_entrega').textContent = metodoEntregaText;
        
        // Actualizar dirección si es envío a domicilio
        const direccionContainer = document.getElementById('summary_direccion_container');
        if (metodoEntregaValue === 'envio_domicilio') {
            const direccion = document.getElementById('direccion').value;
            const codigoPostal = document.getElementById('codigo_postal').value;
            document.getElementById('summary_direccion').textContent = direccion + ' (CP: ' + codigoPostal + ')';
            direccionContainer.style.display = 'block';
        } else {
            direccionContainer.style.display = 'none';
        }
        
        // Actualizar método de pago
        const metodoPagoValue = document.querySelector('input[name="metodo_pago"]:checked').value;
        let metodoPagoText = '';
        switch (metodoPagoValue) {
            case 'tarjeta':
                metodoPagoText = 'Tarjeta de Crédito/Débito';
                break;
            case 'transferencia':
                metodoPagoText = 'Transferencia Bancaria';
                break;
            case 'efectivo':
                metodoPagoText = 'Efectivo (solo para retiro en local)';
                break;
        }
        document.getElementById('summary_pago').textContent = metodoPagoText;
    }
    
    // Event listeners para los métodos de entrega
    if (metodoEntrega.length > 0) {
        metodoEntrega.forEach(function(radio) {
            radio.addEventListener('change', function() {
                if (this.value === 'envio_domicilio') {
                    datosEnvio.style.display = 'block';
                    // Simular costo de envío
                    const costoEnvioValor = 500; // $500 de envío
                    costoEnvioElement.textContent = '$' + costoEnvioValor.toFixed(2);
                    inputCostoEnvio.value = costoEnvioValor;
                    
                    // Actualizar total
                    const nuevoTotal = subtotalValue + costoEnvioValor;
                    totalFinalElement.textContent = '$' + nuevoTotal.toFixed(2);
                    inputTotal.value = nuevoTotal;
                    
                    // Deshabilitar opción de efectivo
                    document.getElementById('efectivo').disabled = true;
                    if (document.getElementById('efectivo').checked) {
                        document.getElementById('tarjeta').checked = true;
                        togglePaymentFields();
                    }
                } else {
                    datosEnvio.style.display = 'none';
                    // Sin costo de envío
                    costoEnvioElement.textContent = '$0.00';
                    inputCostoEnvio.value = 0;
                    
                    // Actualizar total
                    totalFinalElement.textContent = '$' + subtotalValue.toFixed(2);
                    inputTotal.value = subtotalValue;
                    
                    // Habilitar opción de efectivo
                    document.getElementById('efectivo').disabled = false;
                }
            });
        });
    }
    
    // Mostrar/ocultar campos según método de pago
    const metodoPago = document.querySelectorAll('input[name="metodo_pago"]');
    const datosTarjeta = document.getElementById('datos_tarjeta');
    const datosTransferencia = document.getElementById('datos_transferencia');
    const datosEfectivo = document.getElementById('datos_efectivo');
    
    function togglePaymentFields() {
        const selectedMethod = document.querySelector('input[name="metodo_pago"]:checked').value;
        
        datosTarjeta.style.display = 'none';
        datosTransferencia.style.display = 'none';
        datosEfectivo.style.display = 'none';
        
        switch (selectedMethod) {
            case 'tarjeta':
                datosTarjeta.style.display = 'block';
                break;
            case 'transferencia':
                datosTransferencia.style.display = 'block';
                break;
            case 'efectivo':
                datosEfectivo.style.display = 'block';
                break;
        }
    }
    
    if (metodoPago.length > 0) {
        metodoPago.forEach(function(radio) {
            radio.addEventListener('change', togglePaymentFields);
        });
        
        // Inicializar campos de pago
        togglePaymentFields();
    }
});