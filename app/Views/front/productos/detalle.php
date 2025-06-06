<?= $this->extend('front/layout/layouts'); ?>

<?= $this->section('contenedor'); ?>
<div class="container producto-detalle-container my-5">
    <!-- Mostrar mensaje Flash si existe -->
    <?php if (session()->getFlashdata('mensaje')): ?>
        <div class="alert alert-info alert-dismissible fade show mb-4 fw-bold" role="alert">
            <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between">
                <div>
                    <i class="fas fa-info-circle me-2"></i><?= session()->getFlashdata('mensaje') ?>
                </div>
                <a href="<?= base_url('carrito') ?>" class="btn btn-info btn-sm mt-2 mt-sm-0"><i class="fas fa-shopping-cart me-1"></i>Ver carrito</a>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    <?php endif; ?>
    
    <!-- Título del producto -->
    <h1 class="producto-titulo mb-4"><?= esc($producto['nombre']); ?></h1>
    
    <div class="row">
        <!-- Columna izquierda: Imagen -->
        <div class="col-md-6">
            <div class="producto-imagen-container mb-4">
                <img src="<?= base_url('public/' . $producto['imagen']); ?>" class="producto-imagen img-fluid" alt="<?= esc($producto['nombre']); ?>">
            </div>
        </div>
        
        <!-- Columna derecha: Precio y botones -->
        <div class="col-md-6">
            <div class="producto-info">
                <div class="producto-precio mb-4">
                    <span class="precio-etiqueta">Precio:</span>
                    <span class="precio-valor">$<?= esc($producto['precio_vta']); ?></span>
                </div>

                <div class="producto-stock mb-4">
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

                <!-- Formulario con selector de cantidad -->
                <div class="producto-acciones mt-4">
                    <form action="<?= base_url('carrito/add'); ?>" method="post">
                        <?= csrf_field() ?>
                        <input type="hidden" name="id" value="<?= $producto['id']; ?>">
                        <input type="hidden" name="nombre_prod" value="<?= $producto['nombre']; ?>">
                        <input type="hidden" name="precio_vta" value="<?= $producto['precio_vta']; ?>">
                        <input type="hidden" name="imagen" value="<?= $producto['imagen']; ?>">
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="cantidad" class="form-label">Cantidad:</label>
                                <input type="number" name="qty" id="cantidad" class="form-control" value="1" min="1" max="<?= $producto['stock']; ?>">
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex">
                            <button type="submit" class="btn btn-info text-dark btn-comprar">
                                <i class="fas fa-cart-plus me-2"></i>Añadir al carrito
                            </button>
                            <a href="<?= base_url('productos'); ?>" class="btn btn-outline-secondary btn-volver">
                                <i class="fas fa-arrow-left me-2"></i>Volver al catálogo
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Descripción debajo de la imagen -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="producto-descripcion p-3 border rounded">
                <h3>Descripción</h3>
                <p><?= esc($producto['descripcion']); ?></p>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>
