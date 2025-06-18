/**
 * @fileoverview Gestión del proceso de checkout (finalización de compra)
 * Este archivo maneja la navegación entre pasos del checkout, cálculo de costos,
 * gestión de métodos de pago y envío, y actualización del resumen de compra.
 */

document.addEventListener('DOMContentLoaded', function() {
    // Esperar a que todos los scripts se carguen completamente
    setTimeout(function() {
        // Verificar si estamos en la página de checkout
        const checkoutElement = document.getElementById('checkout');
        if (!checkoutElement) return;
        
        /**
         * Elementos de navegación del checkout
         */
        const checkoutSteps = document.querySelectorAll('.checkout-step');
        const stepContents = document.querySelectorAll('.checkout-step-content');
        const nextStepBtn = document.getElementById('nextStepBtn');
        const prevStepBtn = document.getElementById('prevStepBtn');
        const submitBtn = document.getElementById('submitCheckoutBtn');
        let currentStep = 0;
        
        /**
         * Elementos para el cálculo del envío y pago
         */
        const metodoEntregaRadios = document.querySelectorAll('input[name="metodo_entrega"]');
        const metodoPagoRadios = document.querySelectorAll('input[name="metodo_pago"]');
        const efectivoRadio = document.getElementById('efectivo');
        const datosEnvio = document.getElementById('datos_envio');
        const subtotalValue = parseFloat(document.getElementById('subtotal_value').value);
        const shippingCostDisplay = document.getElementById('shipping_cost_display');
        const totalAmountDisplay = document.getElementById('total_amount_display');
        const inputCostoEnvio = document.querySelector('input[name="costo_envio"]');
        const inputTotal = document.querySelector('input[name="total"]');
        
        /**
         * Actualiza el costo de envío y el total según el método de entrega seleccionado
         * También gestiona la disponibilidad del pago en efectivo según el método de entrega
         */
        function updateShippingAndTotal() {
            const isEnvioDomicilio = document.getElementById('envio_domicilio').checked;
            const shippingCost = isEnvioDomicilio ? 10000 : 0; // $10.000 de costo de envío
            const total = subtotalValue + shippingCost;
            
            // Actualizar displays
            shippingCostDisplay.textContent = '$' + shippingCost.toFixed(2).replace('.', ',');
            totalAmountDisplay.textContent = '$' + total.toFixed(2).replace('.', ',');
            
            // Actualizar campos ocultos
            inputCostoEnvio.value = shippingCost;
            inputTotal.value = total;
            
            // Deshabilitar opción de efectivo si es envío a domicilio
            if (isEnvioDomicilio) {
                efectivoRadio.disabled = true;
                // Si efectivo estaba seleccionado, cambiar a tarjeta
                if (efectivoRadio.checked) {
                    document.getElementById('tarjeta').checked = true;
                    togglePaymentFields();
                }
                // Agregar mensaje visual
                const efectivoLabel = document.querySelector('label[for="efectivo"]');
                if (efectivoLabel) {
                    efectivoLabel.classList.add('text-muted');
                    efectivoLabel.title = 'No disponible para envío a domicilio';
                }
            } else {
                efectivoRadio.disabled = false;
                // Quitar mensaje visual
                const efectivoLabel = document.querySelector('label[for="efectivo"]');
                if (efectivoLabel) {
                    efectivoLabel.classList.remove('text-muted');
                    efectivoLabel.title = '';
                }
            }
        }
        
        /**
         * Muestra u oculta los campos específicos según el método de pago seleccionado
         */
        function togglePaymentFields() {
            const selectedMethod = document.querySelector('input[name="metodo_pago"]:checked').value;
            const datosTarjeta = document.getElementById('datos_tarjeta');
            const datosTransferencia = document.getElementById('datos_transferencia');
            const datosEfectivo = document.getElementById('datos_efectivo');
            
            // Ocultar todos los campos de pago primero
            datosTarjeta.style.display = 'none';
            datosTransferencia.style.display = 'none';
            datosEfectivo.style.display = 'none';
            
            // Mostrar solo los campos correspondientes al método seleccionado
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
        
        /**
         * Actualiza el paso actual del checkout y gestiona la navegación entre pasos
         * @param {number} newStep - El índice del nuevo paso a mostrar
         */
        function updateStep(newStep) {
            // Ocultar todos los pasos primero
            stepContents.forEach(content => {
                content.classList.remove('active');
                content.style.display = 'none';
            });
            
            checkoutSteps.forEach(step => {
                step.classList.remove('active');
            });
            
            // Actualizar paso actual
            currentStep = newStep;
            
            // Mostrar nuevo paso
            if (stepContents[currentStep]) {
                stepContents[currentStep].classList.add('active');
                stepContents[currentStep].style.display = 'block';
            }
            
            if (checkoutSteps[currentStep]) {
                checkoutSteps[currentStep].classList.add('active');
            }
            
            // Actualizar estado de los botones de navegación
            if (prevStepBtn) {
                prevStepBtn.style.display = currentStep > 0 ? 'block' : 'none';
            }
            
            if (nextStepBtn) {
                nextStepBtn.style.display = currentStep < stepContents.length - 1 ? 'block' : 'none';
            }
            
            if (submitBtn) {
                submitBtn.style.display = currentStep === stepContents.length - 1 ? 'block' : 'none';
            }
            
            // Si es el paso de resumen, actualizar los datos
            if (currentStep === 1) {
                if (typeof updateSummary === 'function') {
                    updateSummary();
                } else {
                    // Usar la implementación local
                    localUpdateSummary();
                }
                // Asegurarse de que el costo de envío y total estén actualizados
                updateShippingAndTotal();
            }
        }
        
        /**
         * Actualiza el resumen de compra con los datos del cliente y selecciones realizadas
         * Esta es una implementación local que se usa si no existe una función global
         */
        function localUpdateSummary() {
            // Actualizar datos del cliente
            const nombreInput = document.getElementById('nombre');
            if (nombreInput) {
                const nombreCompleto = nombreInput.value;
                const summaryNombre = document.getElementById('summary_nombre');
                if (summaryNombre) {
                    summaryNombre.textContent = nombreCompleto;
                }
            }
            
            // Actualizar email
            const emailInput = document.getElementById('email');
            if (emailInput) {
                const email = emailInput.value;
                const summaryEmail = document.getElementById('summary_email');
                if (summaryEmail) {
                    summaryEmail.textContent = email;
                }
            }
            
            // Actualizar teléfono
            const telefonoInput = document.getElementById('telefono');
            if (telefonoInput) {
                const telefono = telefonoInput.value;
                const summaryTelefono = document.getElementById('summary_telefono');
                if (summaryTelefono) {
                    summaryTelefono.textContent = telefono || 'No proporcionado';
                }
            }
            
            // Actualizar método de entrega
            const metodoEntregaChecked = document.querySelector('input[name="metodo_entrega"]:checked');
            if (metodoEntregaChecked) {
                const metodoEntregaValue = metodoEntregaChecked.value;
                const metodoEntregaText = metodoEntregaValue === 'retiro_local' ? 'Retiro en local' : 'Envío a domicilio';
                const summaryEntrega = document.getElementById('summary_entrega');
                if (summaryEntrega) {
                    summaryEntrega.textContent = metodoEntregaText;
                }
            }
            
            // Actualizar dirección si es envío a domicilio
            if (metodoEntregaChecked && metodoEntregaChecked.value === 'envio_domicilio') {
                const direccion = document.getElementById('direccion').value;
                const provincia = document.getElementById('provincia').value;
                const localidad = document.getElementById('localidad').value;
                const codigoPostal = document.getElementById('codigo_postal').value;
                
                const summaryDireccion = document.getElementById('summary_direccion');
                const summaryProvincia = document.getElementById('summary_provincia');
                const summaryLocalidad = document.getElementById('summary_localidad');
                const summaryCodigoPostal = document.getElementById('summary_codigo_postal');
                
                if (summaryDireccion) summaryDireccion.textContent = direccion;
                if (summaryProvincia) summaryProvincia.textContent = provincia;
                if (summaryLocalidad) summaryLocalidad.textContent = localidad;
                if (summaryCodigoPostal) summaryCodigoPostal.textContent = codigoPostal;
                
                // Mostrar los contenedores de información de dirección
                const direccionContainer = document.getElementById('summary_direccion_container');
                const provinciaContainer = document.getElementById('summary_provincia_container');
                const localidadContainer = document.getElementById('summary_localidad_container');
                const codigoPostalContainer = document.getElementById('summary_codigo_postal_container');
                
                if (direccionContainer) direccionContainer.style.display = 'block';
                if (provinciaContainer) provinciaContainer.style.display = 'block';
                if (localidadContainer) localidadContainer.style.display = 'block';
                if (codigoPostalContainer) codigoPostalContainer.style.display = 'block';
            } else {
                // Ocultar los contenedores de información de dirección si no es envío a domicilio
                const direccionContainer = document.getElementById('summary_direccion_container');
                const provinciaContainer = document.getElementById('summary_provincia_container');
                const localidadContainer = document.getElementById('summary_localidad_container');
                const codigoPostalContainer = document.getElementById('summary_codigo_postal_container');
                
                if (direccionContainer) direccionContainer.style.display = 'none';
                if (provinciaContainer) provinciaContainer.style.display = 'none';
                if (localidadContainer) localidadContainer.style.display = 'none';
                if (codigoPostalContainer) codigoPostalContainer.style.display = 'none';
            }
            
            // Actualizar método de pago y mostrar detalles específicos según el método
            const metodoPagoChecked = document.querySelector('input[name="metodo_pago"]:checked');
            if (metodoPagoChecked) {
                const metodoPagoValue = metodoPagoChecked.value;
                let metodoPagoText = '';
                
                switch (metodoPagoValue) {
                    case 'tarjeta':
                        const numeroTarjeta = document.getElementById('numero_tarjeta');
                        const ultimosDigitos = numeroTarjeta && numeroTarjeta.value ? 
                            numeroTarjeta.value.replace(/\s/g, '').slice(-4) : '';
                        metodoPagoText = ultimosDigitos ? 
                            `Tarjeta terminada en ${ultimosDigitos}` : 'Tarjeta de Crédito/Débito';
                        break;
                    case 'transferencia':
                        metodoPagoText = 'Transferencia Bancaria';
                        break;
                    case 'efectivo':
                        metodoPagoText = 'Efectivo (solo para retiro en local)';
                        break;
                }
                
                const summaryPago = document.getElementById('summary_pago');
                if (summaryPago) {
                    summaryPago.textContent = metodoPagoText;
                }
            }
        }
        
        /**
         * Inicialización del checkout
         */
        // Inicializar el primer paso
        if (checkoutSteps.length > 0 && stepContents.length > 0) {
            // Ocultar todos los pasos primero
            stepContents.forEach(content => {
                content.style.display = 'none';
            });
            
            // Mostrar solo el primer paso
            updateStep(0);
        }
        
        /**
         * Configuración de eventos para navegación entre pasos
         */
        // Event listeners para los botones de navegación
        if (nextStepBtn) {
            nextStepBtn.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Validar campos requeridos antes de avanzar
                if (currentStep === 0) {
                    // Aquí puedes agregar validación si es necesario
                    // Por ahora, simplemente avanzamos al siguiente paso
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
        
        /**
         * Configuración de eventos para métodos de entrega y pago
         */
        // Event listeners para los métodos de entrega - muestra/oculta campos de dirección
        metodoEntregaRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.value === 'envio_domicilio') {
                    datosEnvio.style.display = 'block';
                } else {
                    datosEnvio.style.display = 'none';
                }
                // Llamar a updateShippingAndTotal inmediatamente después del cambio
                updateShippingAndTotal();
            });
        });
        
        // Event listeners para los métodos de pago - muestra/oculta campos específicos
        metodoPagoRadios.forEach(radio => {
            radio.addEventListener('change', togglePaymentFields);
        });
        
        /**
         * Inicialización de estados
         */
        // Inicializar campos de pago y costo de envío
        togglePaymentFields();
        updateShippingAndTotal();
        
        // Forzar una actualización inicial para asegurar que el estado sea correcto
        const envioDomicilioRadio = document.getElementById('envio_domicilio');
        if (envioDomicilioRadio && envioDomicilioRadio.checked) {
            datosEnvio.style.display = 'block';
            updateShippingAndTotal();
        }
        
    }, 1000); // Reducido a 1 segundo para una carga más rápida
});