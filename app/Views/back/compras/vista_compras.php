<div class="container my-5">
    <div class="card bg-dark text-info border-info">
        <div class="card-header bg-info text-dark">
            <h3 class="mb-0">Detalle de Compra</h3>
        </div>
        <div class="card-body">
            <?php if (session()->getFlashdata('mensaje')): ?>
                <div class="alert alert-info alert-dismissible fade show mb-4" role="alert">
                    <i class="fas fa-info-circle me-2"></i><?= session()->getFlashdata('mensaje') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
            <?php endif; ?>
            
            <?php 
            // Obtener datos adicionales si existen
            $datos_adicionales = [];
            if (!empty($venta[0]['datos_adicionales'])) {
                $datos_adicionales = json_decode($venta[0]['datos_adicionales'], true);
            }
            ?>
            
            <?php if (!empty($datos_adicionales)): ?>
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card bg-dark border-info mb-3">
                        <div class="card-header bg-info text-dark">
                            <h5 class="mb-0">Datos del Cliente</h5>
                        </div>
                        <div class="card-body">
                            <p><strong>Nombre:</strong> <?= esc($datos_adicionales['nombre']) ?></p>
                            <p><strong>Email:</strong> <?= esc($datos_adicionales['email']) ?></p>
                            <p><strong>Teléfono:</strong> <?= esc($datos_adicionales['telefono']) ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card bg-dark border-info mb-3">
                        <div class="card-header bg-info text-dark">
                            <h5 class="mb-0">Datos de Entrega y Pago</h5>
                        </div>
                        <div class="card-body">
                            <p><strong>Método de entrega:</strong> 
                                <?= $datos_adicionales['metodo_entrega'] === 'retiro_local' ? 'Retiro en local' : 'Envío a domicilio' ?>
                            </p>
                            
                            <?php if ($datos_adicionales['metodo_entrega'] === 'envio_domicilio'): ?>
                                <p><strong>Dirección:</strong> <?= esc($datos_adicionales['direccion']) ?></p>
                                <p><strong>Ciudad:</strong> <?= esc($datos_adicionales['ciudad']) ?></p>
                                <p><strong>Código Postal:</strong> <?= esc($datos_adicionales['codigo_postal']) ?></p>
                            <?php endif; ?>
                            
                            <p><strong>Método de pago:</strong> 
                                <?php 
                                switch ($datos_adicionales['metodo_pago']) {
                                    case 'tarjeta':
                                        echo 'Tarjeta de Crédito/Débito';
                                        break;
                                    case 'transferencia':
                                        echo 'Transferencia Bancaria';
                                        break;
                                    case 'efectivo':
                                        echo 'Efectivo';
                                        break;
                                }
                                ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            
            <div class="table-responsive">
                <table class="table table-dark table-hover">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Imagen</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $total = 0;
                        foreach ($venta as $item): 
                            $total += $item['precio'];
                        ?>
                        <tr>
                            <td><?= esc($item['nombre']) ?></td>
                            <td>
                                <img src="<?= base_url('assets/img/' . $item['imagen']) ?>" 
                                     alt="<?= esc($item['nombre']) ?>" 
                                     width="50" height="50">
                            </td>
                            <td><?= $item['cantidad'] ?></td>
                            <td>$<?= number_format($item['precio'] / $item['cantidad'], 2) ?></td>
                            <td>$<?= number_format($item['precio'], 2) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <?php if (!empty($datos_adicionales) && isset($datos_adicionales['metodo_entrega']) && $datos_adicionales['metodo_entrega'] === 'envio_domicilio'): ?>
                        <tr>
                            <th colspan="4" class="text-end">Costo de envío:</th>
                            <td>$500.00</td>
                        </tr>
                        <?php endif; ?>
                        <tr>
                            <th colspan="4" class="text-end">Total:</th>
                            <th>$<?= number_format($total + (!empty($datos_adicionales) && isset($datos_adicionales['metodo_entrega']) && $datos_adicionales['metodo_entrega'] === 'envio_domicilio' ? 500 : 0), 2) ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="mt-4 text-center">
                <a href="<?= base_url('productos') ?>" class="btn btn-info">Seguir comprando</a>
                <a href="<?= base_url('mis_compras/' . session('id_usuario')) ?>" class="btn btn-outline-info">Ver todas mis compras</a>
            </div>
        </div>
    </div>
</div>