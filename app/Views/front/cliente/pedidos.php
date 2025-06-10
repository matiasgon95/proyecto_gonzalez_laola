<?= $this->extend('front/layout/layouts') ?>
<?= $this->section('contenedor') ?>

<div class="container-fluid py-5 bg-dark text-info">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card bg-dark border-info mb-4">
                    <div class="card-header bg-dark border-info d-flex justify-content-between align-items-center">
                        <h2 class="mb-0">Mis Pedidos</h2>
                        <a href="<?= base_url('front/cliente/dashboard') ?>" class="btn btn-outline-info rounded-pill px-4">
                            <i class="fas fa-arrow-left me-2"></i>Volver al Dashboard
                        </a>
                    </div>
                    <div class="card-body">
                        <?php if (session()->getFlashdata('mensaje')) : ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <?= session()->getFlashdata('mensaje') ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (session()->getFlashdata('error')) : ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?= session()->getFlashdata('error') ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <div class="table-responsive">
                            <table class="table table-hover table-dark table-striped align-middle mb-0">
                                <thead class="table-info text-black">
                                    <tr>
                                        <th>Pedido #</th>
                                        <th>Fecha</th>
                                        <th>Total</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($pedidos) && is_array($pedidos)) : ?>
                                        <?php foreach ($pedidos as $pedido) : ?>
                                            <tr>
                                                <td class="text-center"><?= esc($pedido['id']) ?></td>
                                                <td class="text-center"><?= date('d/m/Y H:i', strtotime($pedido['fecha'])) ?></td>
                                                <td class="text-center">$<?= number_format($pedido['total_venta'], 2) ?></td>
                                                <td class="text-center">
                                                    <a href="<?= base_url('front/cliente/detalle_pedido/' . $pedido['id']) ?>" class="btn btn-sm btn-info">
                                                        <i class="fas fa-eye"></i> Ver detalle
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
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