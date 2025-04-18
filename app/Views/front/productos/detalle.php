<?= $this->extend('front/layouts'); ?>

<?= $this->section('contenedor'); ?>
<div class="container">
    <h1><?= esc($producto['nombre']); ?></h1>

    <div class="card mb-4">
        <img src="<?= base_url('assets/img/' . esc($producto['id']) . '.jpg'); ?>" class="card-img-top" alt="<?= esc($producto['nombre']); ?>">

        <div class="card-body">
            <h5 class="card-title"><?= esc($producto['nombre']); ?></h5>
            <p class="card-text"><?= esc($producto['descripcion']); ?></p>
            <p class="card-text text-muted">Precio: $<?= esc($producto['precio']); ?></p>
            <a href="<?= base_url('productos'); ?>" class="btn btn-secondary">Volver al catálogo</a>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>
