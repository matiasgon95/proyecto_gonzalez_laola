<?= $this->extend('front/layout/layouts') ?>
<?= $this->section('contenedor') ?>

<!-- Contenedor principal con fondo oscuro y texto en color info -->
<div class="container-fluid py-5 bg-dark text-info">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Tarjeta principal que contiene la lista de pedidos -->
                <div class="card bg-dark border-info mb-4">
                    <!-- Encabezado con título y botón para volver al panel -->
                    <div class="card-header bg-dark border-info d-flex justify-content-between align-items-center">
                        <h2 class="mb-0">Mis Pedidos</h2>
                        <a href="<?= base_url('front/cliente/dashboard') ?>" class="btn btn-outline-info rounded-pill px-4">
                            <i class="fas fa-arrow-left me-2"></i>Volver al Panel
                        </a>
                    </div>
                    <div class="card-body">
                        <!-- Mensajes de éxito del sistema -->
                        <?php if (session()->getFlashdata('mensaje')) : ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <?= session()->getFlashdata('mensaje') ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Mensajes de error del sistema -->
                        <?php if (session()->getFlashdata('error')) : ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?= session()->getFlashdata('error') ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                        <!-- Alerta para dispositivos móviles sobre desplazamiento horizontal -->
                        <div class="d-block d-md-none alert alert-info py-2 mb-2 text-center small">
                            <i class="fas fa-arrows-left-right me-1"></i> Desliza horizontalmente para ver toda la tabla
                        </div>
                        <!-- Tabla responsive para mostrar los pedidos -->
                        <div class="table-responsive">
                            <table class="table table-hover table-dark table-striped align-middle mb-0">
                                <thead class="table-info text-black">
                                    <tr>
                                        <th class="text-center">Pedido #</th>
                                        <th class="text-center">Fecha</th>
                                        <th class="text-center">Total</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Iteración sobre el array de pedidos si existe -->
                                    <?php if (!empty($pedidos) && is_array($pedidos)) : ?>
                                        <?php foreach ($pedidos as $pedido) : ?>
                                            <tr>
                                                <td class="text-center"><?= esc($pedido['id']) ?></td>
                                                <td class="text-center"><?= date('d/m/Y H:i', strtotime($pedido['fecha'])) ?></td>
                                                <td class="text-center">$<?= number_format($pedido['total_venta'], 2, ',', '.') ?></td>
                                                <td class="text-center">
                                                    <!-- Botones de acción para cada pedido -->
                                                    <div class="btn-group" role="group">
                                                        <a href="<?= base_url('front/cliente/detalle_pedido/' . $pedido['id']) ?>" class="btn btn-sm btn-info me-2">
                                                            <i class="fas fa-eye"></i> Ver detalle
                                                        </a>
                                                        <a href="<?= base_url('carrito/generar_factura/' . $pedido['id']) ?>" class="btn btn-sm btn-success">
                                                            <i class="fas fa-file-invoice"></i> Ver factura
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <!-- Mensaje cuando no hay pedidos -->
                                    <?php else : ?>
                                        <tr>
                                            <td colspan="4" class="text-center">No tienes pedidos registrados</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>