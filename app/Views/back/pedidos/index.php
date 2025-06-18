<?= $this->extend('front/layout/layouts') ?>
<?= $this->section('contenedor') ?>

<!-- Contenedor principal de la página de pedidos -->
<div class="container-fluid py-4">
    <!-- Encabezado con título y botón de retorno -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
        <h1 class="h2 text-info mb-3 mb-md-0">Listado de Pedidos</h1>
        <a href="<?= base_url('back/dashboard') ?>" class="btn btn-outline-info rounded-pill px-4">
            <i class="fas fa-arrow-left"></i> Volver al Panel
        </a>
    </div>

    <!-- Mensaje de éxito (si existe) -->
    <?php if (session()->getFlashdata('mensaje')) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('mensaje') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Tarjeta principal con la tabla de pedidos -->
    <div class="card shadow border border-info">
        <div class="card-body p-0 p-sm-2">
            <!-- Alerta de desplazamiento horizontal para dispositivos móviles -->
            <div class="d-block d-md-none alert alert-info py-2 mb-2 text-center small">
                <i class="fas fa-arrows-left-right me-1"></i> Desliza horizontalmente para ver toda la tabla
            </div>
            <!-- Contenedor responsive para la tabla -->
            <div class="table-responsive">
                <!-- Tabla de pedidos -->
                <table class="table table-hover table-dark table-striped align-middle mb-0 admin-table">
                    <!-- Encabezado de la tabla -->
                    <thead class="table-info text-black">
                        <tr>
                            <th class="text-center">ID</th>
                            <th class="text-center">Fecha</th>
                            <th class="text-center">Cliente</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">Total</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <!-- Cuerpo de la tabla -->
                    <tbody>
                        <!-- Verificación de existencia de pedidos -->
                        <?php if (!empty($pedidos) && is_array($pedidos)) : ?>
                            <!-- Iteración sobre cada pedido -->
                            <?php foreach ($pedidos as $pedido) : ?>
                                <tr>
                                    <td class="text-center"><?= esc($pedido['id']) ?></td>
                                    <td class="text-center"><?= date('d/m/Y H:i', strtotime($pedido['fecha'])) ?></td>
                                    <td class="text-center"><?= esc($pedido['nombre'] . ' ' . $pedido['apellido']) ?></td>
                                    <td class="text-center"><?= esc($pedido['email']) ?></td>
                                    <td class="text-center">$<?= number_format($pedido['total_venta'], 2, ',', '.') ?></td>
                                    <td class="text-center">
                                        <!-- Botón para ver detalle del pedido -->
                                        <a href="<?= base_url('back/pedidos/detalle/' . $pedido['id']) ?>" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i> Ver detalle
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <!-- Mensaje cuando no hay pedidos -->
                            <tr>
                                <td colspan="6" class="text-center">No hay pedidos registrados</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>