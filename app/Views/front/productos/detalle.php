<?= $this->extend('front/layout/layouts'); ?>

<?= $this->section('contenedor'); ?>
<div class="container producto-detalle-container my-5">
    <div class="row">
        <div class="col-md-6">
            <div class="producto-imagen-container">
                <img src="<?= base_url('public/' . $producto['imagen']); ?>" class="producto-imagen" alt="<?= esc($producto['nombre']); ?>">
            </div>
        </div>
        <div class="col-md-6">
            <div class="producto-info">
                <h1 class="producto-titulo"><?= esc($producto['nombre']); ?></h1>

                <div class="producto-precio mb-3">
                    <span class="precio-etiqueta">Precio:</span>
                    <span class="precio-valor">$<?= esc($producto['precio']); ?></span>
                </div>

                <div class="producto-stock mb-3">
                    <?php
                        $stock = $producto['stock'];
                        $stock_min = $producto['stock_min'];
                        $diferencia = $stock - $stock_min;
                    ?>

                    <?php if ($stock <= $stock_min): ?>
                        <span class="text-warning fw-bold">¡Pocos en stock! (<?= esc($stock); ?> disponibles)</span>
                    <?php elseif ($diferencia <= 5): ?>
                        <span class="text-danger fw-bold">Últimas unidades (<?= esc($stock); ?> disponibles)</span>
                    <?php else: ?>
                        <span class="text-success fw-bold">+<?= esc($diferencia); ?> disponibles</span>
                    <?php endif; ?>
                </div>

                <div class="producto-descripcion">
                    <h3>Descripción</h3>
                    <p><?= esc($producto['descripcion']); ?></p>
                </div>

                <div class="producto-acciones mt-4">
                    <a href="#" class="btn btn-primary btn-comprar"><i class="bi bi-cart-plus me-2"></i>Añadir al carrito</a>
                    <a href="<?= base_url('productos'); ?>" class="btn btn-outline-secondary btn-volver"><i class="bi bi-arrow-left me-2"></i>Volver al catálogo</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>
