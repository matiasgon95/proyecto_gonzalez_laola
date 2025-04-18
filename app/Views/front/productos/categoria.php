<?= $this->extend('front/layouts'); ?>

<?= $this->section('contenedor'); ?>
<div class="row">
    <!-- Barra lateral de categorías -->
    <div class="col-md-3">
        <div class="sidebar">
            <h3>Categorías</h3>
            <ul class="list-group">
                <?php foreach ($categorias as $categoria): ?>
                    <li class="list-group-item">
                        <a href="/categoria/<?= urlencode($categoria); ?>"><?= esc($categoria); ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

    <!-- Lista de productos -->
    <div class="col-md-9">
        <h1>Catálogo de Productos</h1>
        <div class="row">
            <?php foreach ($productos as $producto): ?>
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm">
                        <!-- Imagen del producto -->
                        <img src="assets/img/<?= esc($producto['id']); ?>.jpg" class="card-img-top" alt="<?= esc($producto['nombre']); ?>">

                        <!-- Cuerpo de la tarjeta -->
                        <div class="card-body">
                            <h5 class="card-title"><?= esc($producto['nombre']); ?></h5>
                            <p class="card-text"><?= esc($producto['descripcion']); ?></p>
                            <p class="card-text text-muted">Precio: $<?= esc($producto['precio']); ?></p>
                            <a href="/producto/detalle/<?= $producto['id']; ?>" class="btn btn-primary">Ver detalle</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>
