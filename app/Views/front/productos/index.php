<?= $this->extend('front/layout/layouts'); ?>

<?= $this->section('contenedor'); ?>
<div class="container py-4">
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
                                <!-- Modificar la etiqueta de imagen para incluir lazy loading -->
                                <img src="<?= base_url('assets/img/' . esc($producto['id']) . '.jpg'); ?>" 
                                     class="card-img-top imagen-producto" 
                                     alt="<?= esc($producto['nombre']); ?>"
                                     loading="lazy">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title text-info"><?= esc($producto['nombre']); ?></h5>
                                    <p class="card-text flex-grow-1"><?= esc($producto['descripcion']); ?></p>
                                    <div class="mt-auto">
                                        <p class="card-text text-info mb-3">$<?= number_format($producto['precio'], 2); ?></p>
                                        <a href="<?= base_url('producto/detalle/' . $producto['id']); ?>" 
                                           class="btn btn-info text-black rounded-pill w-100">
                                           <i class="fas fa-eye me-2"></i>Ver detalle
                                        </a>
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
