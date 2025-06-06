<?= $this->extend('front/layout/layouts'); ?>

<?= $this->section('contenedor'); ?>
<div class="container py-4">
    <!-- Mostrar mensaje Flash si existe -->
    <?php if (session()->getFlashdata('mensaje')): ?>
        <div class="alert alert-info alert-dismissible fade show mt-3 mb-4 fw-bold" role="alert">
            <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between">
                <div>
                    <i class="fas fa-info-circle me-2"></i><?= session()->getFlashdata('mensaje') ?>
                </div>
                <a href="<?= base_url('carrito') ?>" class="btn btn-info btn-sm mt-2 mt-sm-0"><i class="fas fa-shopping-cart me-1"></i>Ver carrito</a>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    <?php endif; ?>
    
    <div class="row">
        <!-- Barra lateral de categorías -->
        <div class="col-md-3">
            <div class="sidebar shadow-sm">
                <h3>Categorías</h3>
                <ul class="list-group">
                    <?php if (!empty($categorias)): ?>
                        <?php foreach ($categorias as $categoria): ?>
                            <li class="list-group-item">
                                <a href="<?= base_url('producto/categoria/' . urlencode($categoria)); ?>"><?= esc($categoria); ?></a>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li class="list-group-item">No hay categorías disponibles</li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>

        <!-- Lista de productos -->
        <div class="col-md-9">
            <h1 class="mb-4 text-info">Catálogo de Productos</h1>
            <div class="row">
                <?php if (!empty($productos)): ?>
                    <?php foreach ($productos as $producto): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card shadow border border-info h-100">
                            <img src="<?= base_url('public/' . $producto['imagen']) ?>"
                                    class="card-img-top imagen-producto" 
                                    alt="<?= esc($producto['nombre']); ?>"
                                    loading="lazy">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title text-info"><?= esc($producto['nombre']); ?></h5>
                                    <span class="badge bg-info text-dark mb-2"><?= esc($producto['categoria']); ?></span>  <!-- Categoría con badge -->
                                    <!-- <p class="card-text flex-grow-1"><?= esc($producto['descripcion']); ?></p> -->
                                    <div class="mt-auto">
                                        <p class="card-text text-info mb-3">$<?= number_format($producto['precio_vta'], 2); ?></p>
                                        <a href="<?= base_url('producto/detalle/' . $producto['id']); ?>" 
                                        class="btn btn-info text-black rounded-pill w-100 mb-2">
                                        <i class="fas fa-eye me-2"></i>Ver detalle
                                        </a>
                                        
                                        <!-- Botón Agregar al Carrito -->
                                        <form action="<?= base_url('carrito/add'); ?>" method="post" class="mt-2">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="id" value="<?= $producto['id']; ?>">
                                            <input type="hidden" name="nombre_prod" value="<?= $producto['nombre']; ?>">
                                            <input type="hidden" name="precio_vta" value="<?= $producto['precio']; ?>">
                                            <input type="hidden" name="imagen" value="<?= $producto['imagen']; ?>">
                                            <button type="submit" class="btn btn-primary rounded-pill w-100">
                                                <i class="fas fa-cart-plus me-2"></i>Añadir al carrito
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-center text-muted">
                        <p>No hay productos en esta categoría.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>
