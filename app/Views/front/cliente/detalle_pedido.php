<?= $this->extend('front/layout/layouts') ?> <!-- Extiende la plantilla principal de layouts -->
<?= $this->section('contenedor') ?> <!-- Inicia la sección 'contenedor' que se insertará en la plantilla -->

<!-- Contenedor principal con fondo oscuro y texto en color info (azul claro) -->
<div class="container-fluid py-5 bg-dark text-info">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10"> <!-- Limita el ancho del contenido para mejor legibilidad -->
                <!-- Tarjeta principal que contiene toda la información del pedido -->
                <div class="card bg-dark border-info mb-4">
                    <!-- Encabezado de la tarjeta con título y botón para volver -->
                    <div class="card-header bg-dark border-info d-flex justify-content-between align-items-center">
                        <h2 class="mb-0">Detalle del Pedido #<?= esc($pedido['id']) ?></h2> <!-- Muestra el ID del pedido con escape para seguridad -->
                        <a href="<?= base_url('front/cliente/pedidos') ?>" class="btn btn-outline-info rounded-pill px-4">
                            <i class="fas fa-arrow-left me-2"></i>Volver a Mis Pedidos
                        </a>
                    </div>
                    <div class="card-body">
                        <!-- Sección de información del cliente y del pedido en dos columnas -->
                        <div class="row mb-4">
                            <!-- Columna izquierda: Datos del cliente -->
                            <div class="col-md-6">
                                <div class="card bg-dark border-info mb-3">
                                    <div class="card-header bg-info text-dark">
                                        <h5 class="mb-0">Datos del Cliente</h5>
                                    </div>
                                    <div class="card-body">
                                        <!-- Información personal del cliente con escape para seguridad -->
                                        <p><strong>Nombre:</strong> <?= esc($pedido['nombre'] . ' ' . $pedido['apellido']) ?></p>
                                        <p><strong>Email:</strong> <?= esc($pedido['email']) ?></p>
                                        <p><strong>Provincia:</strong> <?= esc($pedido['provincia']) ?></p>
                                    </div>
                                </div>
                            </div>
                            <!-- Columna derecha: Datos del pedido -->
                            <div class="col-md-6">
                                <div class="card bg-dark border-info mb-3">
                                    <div class="card-header bg-info text-dark">
                                        <h5 class="mb-0">Datos del Pedido</h5>
                                    </div>
                                    <div class="card-body">
                                        <!-- Fecha formateada y total con formato de moneda -->
                                        <p><strong>Fecha:</strong> <?= date('d/m/Y H:i', strtotime($pedido['fecha'])) ?></p>
                                        <p><strong>Total:</strong> $<?= number_format($pedido['total_venta'], 2, ',', '.') ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sección de tabla de productos incluidos en el pedido -->
                        <div class="card bg-dark border-info">
                            <div class="card-header bg-info text-dark">
                                <h5 class="mb-0">Productos del Pedido</h5>
                            </div>
                            <div class="card-body p-0 p-sm-2"> <!-- Padding reducido en móviles para aprovechar espacio -->
                                <!-- Tabla responsive para adaptarse a diferentes tamaños de pantalla -->
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
                                            <!-- Verificación de que existan detalles para mostrar -->
                                            <?php if (!empty($detalles) && is_array($detalles)) : ?>
                                                <!-- Iteración sobre cada detalle del pedido -->
                                                <?php foreach ($detalles as $detalle) : ?>
                                                    <tr>
                                                        <td><?= esc($detalle['nombre']) ?></td>
                                                        <td class="text-center">
                                                            <!-- Manejo condicional para mostrar imagen o mensaje si no existe -->
                                                            <?php if (!empty($detalle['imagen'])) : ?>
                                                                <img src="<?= base_url('public/' . $detalle['imagen']) ?>" alt="<?= esc($detalle['nombre']) ?>" class="img-thumbnail" style="max-width: 80px;">
                                                            <?php else : ?>
                                                                <span class="text-muted">Sin imagen</span>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td class="text-center"><?= esc($detalle['cantidad']) ?></td>
                                                        <!-- Cálculo del precio unitario dividiendo el precio total entre la cantidad -->
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
                                                <!-- Fila de total al final de la tabla -->
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
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?> <!-- Finaliza la sección 'contenedor' -->