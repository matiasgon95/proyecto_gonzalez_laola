<?= $this->extend('front/layout/layouts') ?>
<?= $this->section('contenedor') ?>

<div class="container-fluid py-5 bg-dark text-info">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card bg-dark border-info mb-4">
                    <div class="card-header bg-dark border-info d-flex justify-content-between align-items-center">
                        <h2 class="mb-0">Mis Productos Favoritos</h2>
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

                        <?php if (!empty($favoritos) && is_array($favoritos)) : ?>
                            <div class="row">
                                <?php foreach ($favoritos as $favorito) : ?>
                                    <div class="col-md-4 mb-4">
                                        <div class="card shadow border border-info h-100">
                                            <img src="<?= base_url('public/' . $favorito['imagen']) ?>" 
                                                class="card-img-top imagen-producto" 
                                                alt="<?= esc($favorito['nombre']); ?>"
                                                loading="lazy">
                                            <div class="card-body d-flex flex-column">
                                                <h5 class="card-title text-info"><?= esc($favorito['nombre']); ?></h5>
                                                <span class="badge bg-info text-dark mb-2"><?= esc($favorito['categoria']); ?></span>
                                                <div class="mt-auto">
                                                    <p class="card-text text-info mb-3">$<?= number_format($favorito['precio_vta'], 2); ?></p>
                                                    <div class="d-flex flex-column gap-2">
                                                        <a href="<?= base_url('producto/detalle/' . $favorito['producto_id']); ?>" 
                                                            class="btn btn-info text-black rounded-pill">
                                                            <i class="fas fa-eye me-2"></i>Ver detalle
                                                        </a>
                                                        <a href="<?= base_url('front/cliente/eliminar_favorito/' . $favorito['producto_id']); ?>" 
                                                            class="btn btn-outline-danger rounded-pill">
                                                            <i class="fas fa-trash me-2"></i>Eliminar de favoritos
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else : ?>
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i> No tienes productos favoritos. Explora nuestro <a href="<?= base_url('productos') ?>" class="alert-link">catálogo de productos</a> y agrega algunos a tus favoritos.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>