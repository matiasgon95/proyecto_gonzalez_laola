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
            <?= csrf_field() ?>
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
                                <input type="hidden" class="form-control" id="nombre" name="nombre" value="<?= session()->get('usuario_nombre') . ' ' . session()->get('usuario_apellido') ?>">
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
                                        <label for="provincia" class="form-label">Provincia</label>
                                        <input type="text" class="form-control" id="provincia" name="provincia">
                                        <div class="invalid-feedback">Por favor ingrese una provincia</div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="localidad" class="form-label">Localidad</label>
                                        <input type="text" class="form-control" id="localidad" name="localidad">
                                        <div class="invalid-feedback">Por favor ingrese una localidad</div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="codigo_postal" class="form-label">Código Postal</label>
                                        <input type="text" class="form-control" id="codigo_postal" name="codigo_postal">
                                        <div class="invalid-feedback">Por favor ingrese un código postal</div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="telefono_contacto" class="form-label">Teléfono de contacto (opcional)</label>
                                        <input type="text" class="form-control" id="telefono_contacto" name="telefono_contacto">
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
                                        <label for="nombre_tarjeta" class="form-label">Nombre y apellido (como figura en la tarjeta)</label>
                                        <input type="text" class="form-control" id="nombre_tarjeta" name="nombre_tarjeta">
                                        <div class="invalid-feedback">Por favor ingrese el nombre como figura en la tarjeta</div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="numero_tarjeta" class="form-label">Número de Tarjeta</label>
                                        <input type="text" class="form-control" id="numero_tarjeta" name="numero_tarjeta" placeholder="XXXX XXXX XXXX XXXX" maxlength="19">
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
                <!-- Sección de información del cliente -->
                <div class="row mb-4">
                    <!-- Datos del cliente -->
                    <div class="col-md-4">
                        <div class="card bg-dark border-info h-100">
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
                    </div>
                    
                    <!-- Detalles de entrega -->
                    <div class="col-md-4">
                        <div class="card bg-dark border-info h-100">
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
                                <div class="checkout-summary-item" id="summary_provincia_container" style="display: none;">
                                    <div class="checkout-summary-label">Provincia:</div>
                                    <div class="checkout-summary-value" id="summary_provincia"></div>
                                </div>
                                <div class="checkout-summary-item" id="summary_localidad_container" style="display: none;">
                                    <div class="checkout-summary-label">Localidad:</div>
                                    <div class="checkout-summary-value" id="summary_localidad"></div>
                                </div>
                                <div class="checkout-summary-item" id="summary_codigo_postal_container" style="display: none;">
                                    <div class="checkout-summary-label">Código Postal:</div>
                                    <div class="checkout-summary-value" id="summary_codigo_postal"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Método de pago -->
                    <div class="col-md-4">
                        <div class="card bg-dark border-info h-100">
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
                    </div>
                </div>
                
                <!-- Resumen de la compra (ocupa todo el ancho) -->
                <div class="row">
                    <div class="col-12">
                        <div class="card bg-dark border-info">
                            <div class="card-header bg-info text-dark">
                                <h4 class="mb-0">Resumen de la Compra</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-dark table-hover">
                                        <thead class="table-info-bright">
                                            <tr>
                                                <th width="60%">PRODUCTO</th>
                                                <th class="text-center" width="15%">CANTIDAD</th>
                                                <th class="text-end" width="25%">PRECIO</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $subtotal = 0; ?>
                                            <?php foreach ($cart as $item): ?>
                                                <?php $subtotal += $item['subtotal']; ?>
                                                <tr>
                                                    <td class="align-middle producto-nombre"><?= esc($item['name']) ?></td>
                                                    <td class="text-center align-middle"><?= $item['qty'] ?></td>
                                                    <td class="text-end align-middle">$<?= number_format($item['price'], 2, ',', '.') ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="2" class="text-end">Subtotal:</td>
                                                <td class="text-end">$<?= number_format($subtotal, 2, ',', '.') ?></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="text-end">Costo de envío:</td>
                                                <td class="text-end" id="shipping_cost_display">$<?= number_format($shipping_cost ?? 0, 2, ',', '.') ?></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="text-end fw-bold">Total:</td>
                                                <td class="text-end fw-bold text-info" id="total_amount_display">$<?= number_format(($subtotal + ($shipping_cost ?? 0)), 2, ',', '.') ?></td>
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

<script>
// Script de inicialización para checkout
document.addEventListener('DOMContentLoaded', function() {
    console.log('Checkout cargado');
    
    // Verificar valores de los campos
    const nombreInput = document.getElementById('nombre');
    console.log('Valor del campo nombre:', nombreInput ? nombreInput.value : 'No encontrado');
    
    // Verificar si updateSummary está disponible
    if (typeof updateSummary === 'function') {
        console.log('updateSummary está disponible');
        
        // Forzar la actualización del resumen después de que todo esté cargado
        setTimeout(function() {
            updateSummary();
            console.log('Resumen actualizado manualmente');
            console.log('Valor de summary_nombre después de actualizar:', 
                document.getElementById('summary_nombre') ? 
                document.getElementById('summary_nombre').textContent : 'No encontrado');
        }, 500);
    } else {
        console.error('La función updateSummary no está disponible');
    }
    
    // Asegurarse de que el resumen se actualice al cambiar de paso
    const nextStepBtn = document.getElementById('nextStepBtn');
    if (nextStepBtn) {
        nextStepBtn.addEventListener('click', function() {
            setTimeout(function() {
                if (typeof updateSummary === 'function') {
                    updateSummary();
                    console.log('Resumen actualizado después de cambiar de paso');
                }
            }, 100);
        });
    }
});
</script>