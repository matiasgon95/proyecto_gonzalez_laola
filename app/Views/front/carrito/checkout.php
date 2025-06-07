<?= $this->extend('front/layout/layouts'); ?>

<?= $this->section('contenedor'); ?>
<div class="container py-4" id="checkout">
    <div class="shadow-sm p-3 p-md-4 bg-dark text-light rounded">
        <div class="heading mb-4">
            <h2 class="text-info text-center">Finalizar Compra</h2>
        </div>
        
        <!-- Mostrar mensaje Flash si existe -->
        <?php if (session()->getFlashdata('mensaje')): ?>
            <div class="alert alert-info alert-dismissible fade show mt-3 mx-3 fw-bold" role="alert">
                <i class="fas fa-info-circle me-2"></i><?= session()->getFlashdata('mensaje') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        <?php endif; ?>
        
        <!-- Indicador de pasos -->
        <div class="checkout-steps mb-4">
            <div class="checkout-step active">
                <div class="checkout-step-number">1</div>
                <p class="checkout-step-title">Datos</p>
            </div>
            <div class="checkout-step">
                <div class="checkout-step-number">2</div>
                <p class="checkout-step-title">Resumen</p>
            </div>
        </div>
        
        <form action="<?= base_url('carrito_confirmar') ?>" method="post">
            <!-- Paso 1: Datos de envío y pago -->
            <div class="checkout-step-content active">
                <div class="row">
                    <!-- Columna de datos personales y envío -->
                    <div class="col-md-6 mb-4">
                        <div class="card bg-dark border-info mb-4">
                            <div class="card-header bg-info text-dark">
                                <h4 class="mb-0">Datos de Envío</h4>
                            </div>
                            <div class="card-body">
                                <!-- Estos campos se llenarán automáticamente con los datos del usuario -->
                                <input type="hidden" class="form-control" id="nombre" name="nombre" value="<?= session()->get('usuario_nombre') ?>">
                                <input type="hidden" class="form-control" id="email" name="email" value="<?= session()->get('usuario_email') ?>">
                                <input type="hidden" class="form-control" id="telefono" name="telefono" value="<?= session()->get('usuario_telefono') ?? '' ?>">
                                
                                <div class="mb-3">
                                    <label class="form-label d-block">Método de entrega</label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="metodo_entrega" id="retiro_local" value="retiro_local" checked>
                                        <label class="form-check-label" for="retiro_local">Retiro en local</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="metodo_entrega" id="envio_domicilio" value="envio_domicilio">
                                        <label class="form-check-label" for="envio_domicilio">Envío a domicilio</label>
                                    </div>
                                </div>
                                
                                <div id="datos_envio" style="display: none;">
                                    <div class="mb-3">
                                        <label for="direccion" class="form-label">Dirección de entrega</label>
                                        <input type="text" class="form-control" id="direccion" name="direccion">
                                        <div class="invalid-feedback">Por favor ingrese una dirección</div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="codigo_postal" class="form-label">Código Postal</label>
                                        <input type="text" class="form-control" id="codigo_postal" name="codigo_postal">
                                        <div class="invalid-feedback">Por favor ingrese un código postal</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Columna de método de pago -->
                    <div class="col-md-6">
                        <div class="card bg-dark border-info">
                            <div class="card-header bg-info text-dark">
                                <h4 class="mb-0">Método de Pago</h4>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="metodo_pago" id="tarjeta" value="tarjeta" checked>
                                        <label class="form-check-label" for="tarjeta">
                                            <i class="fas fa-credit-card me-2"></i>Tarjeta de Crédito/Débito
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="metodo_pago" id="transferencia" value="transferencia">
                                        <label class="form-check-label" for="transferencia">
                                            <i class="fas fa-university me-2"></i>Transferencia Bancaria
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="metodo_pago" id="efectivo" value="efectivo">
                                        <label class="form-check-label" for="efectivo">
                                            <i class="fas fa-money-bill-wave me-2"></i>Efectivo (solo para retiro en local)
                                        </label>
                                    </div>
                                </div>
                                
                                <div id="datos_tarjeta">
                                    <div class="mb-3">
                                        <label for="numero_tarjeta" class="form-label">Número de Tarjeta</label>
                                        <input type="text" class="form-control" id="numero_tarjeta" name="numero_tarjeta" placeholder="XXXX XXXX XXXX XXXX">
                                        <div class="invalid-feedback">Por favor ingrese el número de tarjeta</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="fecha_vencimiento" class="form-label">Fecha de Vencimiento</label>
                                            <input type="text" class="form-control" id="fecha_vencimiento" name="fecha_vencimiento" placeholder="MM/AA">
                                            <div class="invalid-feedback">Por favor ingrese la fecha de vencimiento</div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="cvv" class="form-label">CVV</label>
                                            <input type="text" class="form-control" id="cvv" name="cvv" placeholder="123">
                                            <div class="invalid-feedback">Por favor ingrese el código de seguridad</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div id="datos_transferencia" style="display: none;">
                                    <div class="alert alert-info">
                                        <p class="mb-0">Realiza la transferencia a la siguiente cuenta:</p>
                                        <p class="mb-0">Banco: Banco Ejemplo</p>
                                        <p class="mb-0">Titular: La Ola Informática</p>
                                        <p class="mb-0">CBU: 0000000000000000000000</p>
                                        <p class="mb-0">Alias: LAOLA.INFORMATICA</p>
                                    </div>
                                </div>
                                
                                <div id="datos_efectivo" style="display: none;">
                                    <div class="alert alert-info">
                                        <p class="mb-0">Podrás abonar en efectivo al retirar tu compra en nuestra tienda.</p>
                                        <p class="mb-0">Dirección: Av. Siempreviva 742</p>
                                        <p class="mb-0">Horario: Lunes a Viernes de 9:00 a 18:00</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Paso 2: Resumen de la compra -->
            <div class="checkout-step-content">
                <div class="row">
                    <!-- Columna de datos del cliente -->
                    <div class="col-md-6 mb-4">
                        <div class="card bg-dark border-info mb-4">
                            <div class="card-header bg-info text-dark">
                                <h4 class="mb-0">Datos del Cliente</h4>
                            </div>
                            <div class="card-body">
                                <div class="checkout-summary-item">
                                    <div class="checkout-summary-label">Nombre completo:</div>
                                    <div class="checkout-summary-value" id="summary_nombre"></div>
                                </div>
                                <div class="checkout-summary-item">
                                    <div class="checkout-summary-label">Email:</div>
                                    <div class="checkout-summary-value" id="summary_email"></div>
                                </div>
                                <div class="checkout-summary-item">
                                    <div class="checkout-summary-label">Teléfono:</div>
                                    <div class="checkout-summary-value" id="summary_telefono"></div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card bg-dark border-info">
                            <div class="card-header bg-info text-dark">
                                <h4 class="mb-0">Detalles de Entrega</h4>
                            </div>
                            <div class="card-body">
                                <div class="checkout-summary-item">
                                    <div class="checkout-summary-label">Método de entrega:</div>
                                    <div class="checkout-summary-value" id="summary_entrega"></div>
                                </div>
                                <div class="checkout-summary-item" id="summary_direccion_container" style="display: none;">
                                    <div class="checkout-summary-label">Dirección de entrega:</div>
                                    <div class="checkout-summary-value" id="summary_direccion"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Columna de resumen y pago -->
                    <div class="col-md-6">
                        <div class="card bg-dark border-info mb-4">
                            <div class="card-header bg-info text-dark">
                                <h4 class="mb-0">Método de Pago</h4>
                            </div>
                            <div class="card-body">
                                <div class="checkout-summary-item">
                                    <div class="checkout-summary-label">Forma de pago:</div>
                                    <div class="checkout-summary-value" id="summary_pago"></div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card bg-dark border-info">
                            <div class="card-header bg-info text-dark">
                                <h4 class="mb-0">Resumen de la Compra</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-dark table-hover">
                                        <thead class="table-info text-dark">
                                            <tr>
                                                <th>Producto</th>
                                                <th class="text-center">Cantidad</th>
                                                <th class="text-end">Precio</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $subtotal = 0; ?>
                                            <?php foreach ($cart as $item): ?>
                                                <?php $subtotal += $item['subtotal']; ?>
                                                <tr>
                                                    <td class="align-middle"><?= esc($item['name']) ?></td>
                                                    <td class="text-center align-middle"><?= $item['qty'] ?></td>
                                                    <td class="text-end align-middle">$<?= number_format($item['subtotal'], 2) ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                        <tfoot class="table-dark">
                                            <tr>
                                                <td colspan="2" class="text-end fw-bold">Subtotal:</td>
                                                <td class="text-end fw-bold">$<?= number_format($subtotal, 2) ?></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="text-end">Costo de envío:</td>
                                                <td class="text-end" id="costo_envio">$0.00</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="text-end fw-bold text-info">Total:</td>
                                                <td class="text-end fw-bold text-info" id="total_final">$<?= number_format($subtotal, 2) ?></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Campos ocultos para el envío de datos -->
            <input type="hidden" id="subtotal_value" value="<?= $subtotal ?>">
            <input type="hidden" name="costo_envio" value="0">
            <input type="hidden" name="total" value="<?= $subtotal ?>">
            
            <!-- Botones de navegación -->
            <div class="d-flex justify-content-between mt-4">
                <div>
                    <a href="<?= base_url('carrito') ?>" class="btn btn-outline-info">
                        <i class="fas fa-arrow-left me-2"></i>Volver al Carrito
                    </a>
                    <button type="button" id="prevStepBtn" class="btn btn-outline-info" style="display: none;">
                        <i class="fas fa-arrow-left me-2"></i>Anterior
                    </button>
                </div>
                <div>
                    <button type="button" id="nextStepBtn" class="btn btn-info text-dark">
                        Siguiente<i class="fas fa-arrow-right ms-2"></i>
                    </button>
                    <button type="submit" id="submitCheckoutBtn" class="btn btn-info text-dark" style="display: none;">
                        <i class="fas fa-check-circle me-2"></i>Confirmar Compra
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('js'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mostrar/ocultar campos de dirección según método de entrega
        const metodoEntrega = document.querySelectorAll('input[name="metodo_entrega"]');
        const datosEnvio = document.getElementById('datos_envio');
        const costoEnvioContainer = document.getElementById('costo_envio_container');
        const costoEnvio = document.getElementById('costo_envio');
        const inputCostoEnvio = document.querySelector('input[name="costo_envio"]');
        const totalFinal = document.getElementById('total_final');
        const inputTotal = document.querySelector('input[name="total"]');
        const subtotal = <?= $subtotal ?>;
        
        metodoEntrega.forEach(function(radio) {
            radio.addEventListener('change', function() {
                if (this.value === 'envio_domicilio') {
                    datosEnvio.style.display = 'block';
                    // Simular costo de envío
                    const costoEnvioValor = 500; // $500 de envío
                    costoEnvio.textContent = '$' + costoEnvioValor.toFixed(2);
                    inputCostoEnvio.value = costoEnvioValor;
                    
                    // Actualizar total
                    const nuevoTotal = subtotal + costoEnvioValor;
                    totalFinal.textContent = '$' + nuevoTotal.toFixed(2);
                    inputTotal.value = nuevoTotal;
                } else {
                    datosEnvio.style.display = 'none';
                    // Sin costo de envío
                    costoEnvio.textContent = '$0.00';
                    inputCostoEnvio.value = 0;
                    
                    // Actualizar total
                    totalFinal.textContent = '$' + subtotal.toFixed(2);
                    inputTotal.value = subtotal;
                }
            });
        });
        
        // Mostrar/ocultar campos según método de pago
        const metodoPago = document.querySelectorAll('input[name="metodo_pago"]');
        const datosTarjeta = document.getElementById('datos_tarjeta');
        const datosTransferencia = document.getElementById('datos_transferencia');
        const datosEfectivo = document.getElementById('datos_efectivo');
        
        metodoPago.forEach(function(radio) {
            radio.addEventListener('change', function() {
                datosTarjeta.style.display = 'none';
                datosTransferencia.style.display = 'none';
                datosEfectivo.style.display = 'none';
                
                if (this.value === 'tarjeta') {
                    datosTarjeta.style.display = 'block';
                } else if (this.value === 'transferencia') {
                    datosTransferencia.style.display = 'block';
                } else if (this.value === 'efectivo') {
                    datosEfectivo.style.display = 'block';
                }
            });
        });
        
        // Validar que efectivo solo se pueda seleccionar con retiro en local
        const efectivoRadio = document.getElementById('efectivo');
        const retiroLocalRadio = document.getElementById('retiro_local');
        const envioDomicilioRadio = document.getElementById('envio_domicilio');
        
        envioDomicilioRadio.addEventListener('change', function() {
            if (this.checked && efectivoRadio.checked) {
                // Si selecciona envío a domicilio y tenía efectivo, cambiar a tarjeta
                document.getElementById('tarjeta').checked = true;
                datosTarjeta.style.display = 'block';
                datosEfectivo.style.display = 'none';
            }
            efectivoRadio.disabled = true;
        });
        
        retiroLocalRadio.addEventListener('change', function() {
            efectivoRadio.disabled = false;
        });
    });
</script>
<?= $this->endSection(); ?>