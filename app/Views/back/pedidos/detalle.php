<?= $this->extend('front/layout/layouts') ?>
<?= $this->section('contenedor') ?>

<!-- Contenedor principal de la página de detalle de pedido -->
<div class="container-fluid py-4">
    <!-- Encabezado con título y botón de retorno -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
        <h1 class="h2 text-info mb-3 mb-md-0">Detalle del Pedido #<?= esc($pedido['id']) ?></h1>
        <a href="<?= base_url('back/pedidos') ?>" class="btn btn-outline-info rounded-pill px-4">
            <i class="fas fa-arrow-left"></i> Volver a Pedidos
        </a>
    </div>

    <!-- Sección de información del cliente y del pedido -->
    <div class="row mb-4">
        <!-- Tarjeta con datos del cliente -->
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
        <!-- Tarjeta con datos del pedido -->
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

    <!-- Tarjeta principal con la tabla de productos del pedido -->
    <div class="card shadow border border-info">
        <div class="card-header bg-info text-dark">
            <h5 class="mb-0">Productos del Pedido</h5>
        </div>
        <div class="card-body p-0 p-sm-2">
            <!-- Contenedor responsive para la tabla -->
            <div class="table-responsive">
                <!-- Tabla de productos del pedido -->
                <table class="table table-hover table-dark table-striped align-middle mb-0">
                    <!-- Encabezado de la tabla -->
                    <thead class="table-info text-black">
                        <tr>
                            <th>Producto</th>
                            <th class="text-center">Imagen</th>
                            <th class="text-center">Cantidad</th>
                            <th>Precio</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <!-- Cuerpo de la tabla -->
                    <tbody>
                        <!-- Verificación de existencia de detalles del pedido -->
                        <?php if (!empty($detalles) && is_array($detalles)) : ?>
                            <!-- Iteración sobre cada detalle del pedido -->
                            <?php foreach ($detalles as $detalle) : ?>
                                <tr>
                                    <td><?= esc($detalle['nombre']) ?></td>
                                    <td class="text-center">
                                        <!-- Mostrar imagen del producto si existe -->
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
                            <!-- Calcular el subtotal sumando todos los precios de los detalles -->
                            <?php 
                            $subtotal = 0;
                            foreach ($detalles as $detalle) {
                                $subtotal += $detalle['precio'];
                            }
                            ?>
                            <!-- Mostrar subtotal -->
                            <tr>
                                <td colspan="4" class="text-end">Subtotal:</td>
                                <td>$<?= number_format($subtotal, 2, ',', '.') ?></td>
                            </tr>
                            <!-- Mostrar costo de envío si existe diferencia entre total y subtotal -->
                            <?php if ($pedido['total_venta'] > $subtotal): ?>
                            <tr>
                                <td colspan="4" class="text-end">Costo de envío:</td>
                                <td>$<?= number_format($pedido['total_venta'] - $subtotal, 2, ',', '.') ?></td>
                            </tr>
                            <?php endif; ?>
                            <!-- Fila con el total final del pedido -->
                            <tr class="table-info text-dark">
                                <td colspan="4" class="text-end fw-bold">Total:</td>
                                <td class="fw-bold">$<?= number_format($pedido['total_venta'], 2, ',', '.') ?></td>
                            </tr>
                        <?php else : ?>
                            <!-- Mensaje cuando no hay detalles disponibles -->
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

<?= $this->endSection() ?>