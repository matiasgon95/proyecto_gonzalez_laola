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
        // Eliminar event listeners existentes clonando y reemplazando los elementos
        
        // Botones de suma
        document.querySelectorAll('.btn-cart-suma').forEach(button => {
            const newButton = button.cloneNode(true);
            button.parentNode.replaceChild(newButton, button);
            newButton.addEventListener('click', function(e) {
                e.preventDefault();
                const rowid = this.getAttribute('data-rowid');
                updateCartItem(rowid, 'suma');
            });
        });
        
        // Botones de resta
        document.querySelectorAll('.btn-cart-resta').forEach(button => {
            const newButton = button.cloneNode(true);
            button.parentNode.replaceChild(newButton, button);
            newButton.addEventListener('click', function(e) {
                e.preventDefault();
                const rowid = this.getAttribute('data-rowid');
                updateCartItem(rowid, 'resta');
            });
        });
        
        // Botones de eliminar
        document.querySelectorAll('.btn-cart-remove').forEach(button => {
            const newButton = button.cloneNode(true);
            button.parentNode.replaceChild(newButton, button);
            newButton.addEventListener('click', function(e) {
                e.preventDefault();
                const rowid = this.getAttribute('data-rowid');
                updateCartItem(rowid, 'remove');
            });
        });
        
        // Botón de vaciar carrito
        const clearCartBtn = document.querySelector('.btn-cart-clear');
        if (clearCartBtn) {
            const newClearCartBtn = clearCartBtn.cloneNode(true);
            clearCartBtn.parentNode.replaceChild(newClearCartBtn, clearCartBtn);
            newClearCartBtn.addEventListener('click', function(e) {
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
            const newCheckoutBtn = checkoutBtn.cloneNode(true);
            checkoutBtn.parentNode.replaceChild(newCheckoutBtn, checkoutBtn);
            newCheckoutBtn.addEventListener('click', function(e) {
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
    // Exponemos la función globalmente para que pueda ser llamada desde otros scripts
    window.updateCartCount = function() {
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
            const provincia = document.getElementById('provincia');
            const localidad = document.getElementById('localidad');
            const codigoPostal = document.getElementById('codigo_postal');
            
            if (!direccion.value.trim()) {
                direccion.classList.add('is-invalid');
                isValid = false;
            }
            
            if (!provincia.value.trim()) {
                provincia.classList.add('is-invalid');
                isValid = false;
            }
            
            if (!localidad.value.trim()) {
                localidad.classList.add('is-invalid');
                isValid = false;
            }
            
            if (!codigoPostal.value.trim()) {
                codigoPostal.classList.add('is-invalid');
                isValid = false;
            }
        }
        
        // Validar campos de tarjeta si ese método de pago está seleccionado
        if (document.getElementById('tarjeta') && document.getElementById('tarjeta').checked) {
            const nombreTarjeta = document.getElementById('nombre_tarjeta');
            const numeroTarjeta = document.getElementById('numero_tarjeta');
            const fechaVencimiento = document.getElementById('fecha_vencimiento');
            const cvv = document.getElementById('cvv');
            
            if (!nombreTarjeta.value.trim()) {
                nombreTarjeta.classList.add('is-invalid');
                isValid = false;
            }
            
            if (!numeroTarjeta.value.trim() || numeroTarjeta.value.replace(/\s/g, '').length < 16) {
                numeroTarjeta.classList.add('is-invalid');
                isValid = false;
            }
            
            if (!fechaVencimiento.value.trim() || fechaVencimiento.value.length < 5) {
                fechaVencimiento.classList.add('is-invalid');
                isValid = false;
            }
            
            if (!cvv.value.trim() || cvv.value.length < 3) {
                cvv.classList.add('is-invalid');
                isValid = false;
            }
        }
        
        return isValid;
    }
    
    // Función para actualizar el resumen
    function updateSummary() {
        // Actualizar datos del cliente
        const nombreInput = document.getElementById('nombre');
        if (!nombreInput) {
            console.error('Elemento con ID "nombre" no encontrado');
            return; // Salir de la función si no se encuentra el elemento
        }
        
        const nombreCompleto = nombreInput.value;
        console.log('Valor del campo nombre:', nombreCompleto);
        
        const email = document.getElementById('email') ? document.getElementById('email').value : '';
        const telefono = document.getElementById('telefono') ? document.getElementById('telefono').value : '';
        const telefonoContacto = document.getElementById('telefono_contacto');
        
        // Mostrar nombre completo y teléfono en la sección de datos del cliente
        const summaryNombre = document.getElementById('summary_nombre');
        if (summaryNombre) {
            summaryNombre.textContent = nombreCompleto;
            console.log('Actualizando nombre completo:', nombreCompleto);
        } else {
            console.error('Elemento con ID "summary_nombre" no encontrado');
        }
        
        const summaryEmail = document.getElementById('summary_email');
        if (summaryEmail) {
            summaryEmail.textContent = email;
        }
        
        // Si hay teléfono de contacto y está en modo envío a domicilio, usarlo; de lo contrario, usar el teléfono principal
        const summaryTelefono = document.getElementById('summary_telefono');
        if (summaryTelefono) {
            if (telefonoContacto && telefonoContacto.value && document.querySelector('input[name="metodo_entrega"]:checked').value === 'envio_domicilio') {
                summaryTelefono.textContent = telefonoContacto.value;
            } else {
                summaryTelefono.textContent = telefono || 'No proporcionado';
            }
        }
        
        // Actualizar método de entrega
        const metodoEntregaValue = document.querySelector('input[name="metodo_entrega"]:checked').value;
        const metodoEntregaText = metodoEntregaValue === 'retiro_local' ? 'Retiro en local' : 'Envío a domicilio';
        document.getElementById('summary_entrega').textContent = metodoEntregaText;
        
        // Actualizar dirección si es envío a domicilio
        const direccionContainer = document.getElementById('summary_direccion_container');
        const provinciaContainer = document.getElementById('summary_provincia_container');
        const localidadContainer = document.getElementById('summary_localidad_container');
        const codigoPostalContainer = document.getElementById('summary_codigo_postal_container');
        
        if (metodoEntregaValue === 'envio_domicilio') {
            const direccion = document.getElementById('direccion').value;
            const provincia = document.getElementById('provincia').value;
            const localidad = document.getElementById('localidad').value;
            const codigoPostal = document.getElementById('codigo_postal').value;
            
            document.getElementById('summary_direccion').textContent = direccion;
            document.getElementById('summary_provincia').textContent = provincia;
            document.getElementById('summary_localidad').textContent = localidad;
            document.getElementById('summary_codigo_postal').textContent = codigoPostal;
            
            direccionContainer.style.display = 'block';
            provinciaContainer.style.display = 'block';
            localidadContainer.style.display = 'block';
            codigoPostalContainer.style.display = 'block';
        } else {
            direccionContainer.style.display = 'none';
            provinciaContainer.style.display = 'none';
            localidadContainer.style.display = 'none';
            codigoPostalContainer.style.display = 'none';
        }
        
        // Actualizar método de pago
        const metodoPagoValue = document.querySelector('input[name="metodo_pago"]:checked').value;
        let metodoPagoText = '';
        switch (metodoPagoValue) {
            case 'tarjeta':
                const numeroTarjeta = document.getElementById('numero_tarjeta').value.replace(/\s/g, '');
                const ultimosDigitos = numeroTarjeta.length >= 4 ? numeroTarjeta.slice(-4) : '';
                metodoPagoText = ultimosDigitos ? `Tarjeta terminada en ${ultimosDigitos}` : 'Tarjeta de Crédito/Débito';
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
    
    // Event listeners para los métodos de pago
    if (metodoPago.length > 0) {
        metodoPago.forEach(function(radio) {
            radio.addEventListener('change', togglePaymentFields);
        });
        
        // Inicializar campos de pago
        togglePaymentFields();
        
        // Formatear número de tarjeta automáticamente
        const numeroTarjeta = document.getElementById('numero_tarjeta');
        if (numeroTarjeta) {
            numeroTarjeta.addEventListener('input', function(e) {
                // Eliminar espacios y caracteres no numéricos
                let valor = e.target.value.replace(/\D/g, '');
                
                // Limitar a 16 dígitos
                valor = valor.substring(0, 16);
                
                // Formatear con espacios cada 4 dígitos
                let valorFormateado = '';
                for (let i = 0; i < valor.length; i++) {
                    if (i > 0 && i % 4 === 0) {
                        valorFormateado += ' ';
                    }
                    valorFormateado += valor[i];
                }
                
                // Actualizar el valor del campo
                e.target.value = valorFormateado;
            });
        }
        
        // Formatear fecha de vencimiento automáticamente (MM/AA)
        const fechaVencimiento = document.getElementById('fecha_vencimiento');
        if (fechaVencimiento) {
            fechaVencimiento.addEventListener('input', function(e) {
                // Eliminar caracteres no numéricos
                let valor = e.target.value.replace(/\D/g, '');
                
                // Limitar a 4 dígitos (MMAA)
                valor = valor.substring(0, 4);
                
                // Formatear como MM/AA
                if (valor.length > 2) {
                    valor = valor.substring(0, 2) + '/' + valor.substring(2);
                }
                
                // Actualizar el valor del campo
                e.target.value = valor;
            });
        }
        
        // Limitar CVV a solo 3 dígitos
        const cvv = document.getElementById('cvv');
        if (cvv) {
            cvv.addEventListener('input', function(e) {
                // Eliminar caracteres no numéricos
                let valor = e.target.value.replace(/\D/g, '');
                
                // Limitar a 3 dígitos
                valor = valor.substring(0, 3);
                
                // Actualizar el valor del campo
                e.target.value = valor;
            });
        }
    }
});