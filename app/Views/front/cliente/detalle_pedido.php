<?= $this->extend('front/layout/layouts') ?>
<?= $this->section('contenedor') ?>

<div class="container-fluid py-5 bg-dark text-info">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card bg-dark border-info mb-4">
                    <div class="card-header bg-dark border-info d-flex justify-content-between align-items-center">
                        <h2 class="mb-0">Detalle del Pedido #<?= esc($pedido['id']) ?></h2>
                        <a href="<?= base_url('front/cliente/pedidos') ?>" class="btn btn-outline-info rounded-pill px-4">
                            <i class="fas fa-arrow-left me-2"></i>Volver a Mis Pedidos
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="card bg-dark border-info mb-3">
                                    <div class="card-header bg-info text-dark">
                                        <h5 class="mb-0">Datos del Cliente</h5>
                                    </div>
                                    <div class="card-body">
                                        <p><strong>Nombre:</strong> <?= esc($pedido['nombre'] . ' ' . $pedido['apellido']) ?></p>
                                        <p><strong>Email:</strong> <?= esc($pedido['email']) ?></p>
                                        <p><strong>Provincia:</strong> <?= esc($pedido['provincia']) ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card bg-dark border-info mb-3">
                                    <div class="card-header bg-info text-dark">
                                        <h5 class="mb-0">Datos del Pedido</h5>
                                    </div>
                                    <div class="card-body">
                                        <p><strong>Fecha:</strong> <?= date('d/m/Y H:i', strtotime($pedido['fecha'])) ?></p>
                                        <p><strong>Total:</strong> $<?= number_format($pedido['total_venta'], 2, ',', '.') ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card bg-dark border-info">
                            <div class="card-header bg-info text-dark">
                                <h5 class="mb-0">Productos del Pedido</h5>
                            </div>
                            <div class="card-body p-0 p-sm-2">
                                <div class="table-responsive">
                                    <table class="table table-hover table-dark table-striped align-middle mb-0">
                                        <thead class="table-info text-black">
                                            <tr>
                                                <th>Producto</th>
                                                <th class="text-center">Imagen</th>
                                                <th class="text-center">Cantidad</th>
                                                <th>Precio</th>
                                                <th>Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($detalles) && is_array($detalles)) : ?>
                                                <?php foreach ($detalles as $detalle) : ?>
                                                    <tr>
                                                        <td><?= esc($detalle['nombre']) ?></td>
                                                        <td class="text-center">
                                                            <?php if (!empty($detalle['imagen'])) : ?>
                                                                <img src="<?= base_url('public/' . $detalle['imagen']) ?>" alt="<?= esc($detalle['nombre']) ?>" class="img-thumbnail" style="max-width: 80px;">
                                                            <?php else : ?>
                                                                <span class="text-muted">Sin imagen</span>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td class="text-center"><?= esc($detalle['cantidad']) ?></td>
                                                        <td>$<?= number_format($detalle['precio'] / $detalle['cantidad'], 2, ',', '.') ?></td>
                                                        <td>$<?= number_format($detalle['precio'], 2, ',', '.') ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                                <tr class="table-info text-dark">
                                                    <td colspan="4" class="text-end fw-bold">Total:</td>
                                                    <td class="fw-bold">$<?= number_format($pedido['total_venta'], 2, ',', '.') ?></td>
                                                </tr>
                                            <?php else : ?>
                                                <tr>
                                                    <td colspan="5" class="text-center">No hay detalles disponibles para este pedido</td>
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
    </div>
</div>

<?= $this->endSection() ?>