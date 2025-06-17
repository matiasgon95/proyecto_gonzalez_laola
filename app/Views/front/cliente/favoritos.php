<?= $this->extend('front/layout/layouts') ?>
<?= $this->section('contenedor') ?>

<!-- Contenedor principal con fondo oscuro y texto en color info -->
<div class="container-fluid py-5 bg-dark text-info">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Tarjeta principal que contiene la lista de favoritos -->
                <div class="card bg-dark border-info mb-4">
                    <!-- Encabezado con título y botón para volver al panel -->
                    <div class="card-header bg-dark border-info d-flex justify-content-between align-items-center">
                        <h2 class="mb-0">Mis Productos Favoritos</h2>
                        <a href="<?= base_url('front/cliente/dashboard') ?>" class="btn btn-outline-info rounded-pill px-4">
                            <i class="fas fa-arrow-left me-2"></i>Volver al Panel
                        </a>
                    </div>
                    <div class="card-body">
                        <!-- Mensajes de éxito del sistema -->
                        <?php if (session()->getFlashdata('mensaje')) : ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <?= session()->getFlashdata('mensaje') ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Mensajes de error del sistema -->
                        <?php if (session()->getFlashdata('error')) : ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?= session()->getFlashdata('error') ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <!-- Verificación de existencia de productos favoritos -->
                        <?php if (!empty($favoritos) && is_array($favoritos)) : ?>
                            <!-- Grid de tarjetas de productos favoritos -->
                            <div class="row">
                                <?php foreach ($favoritos as $favorito) : ?>
                                    <!-- Columna para cada producto favorito -->
                                    <div class="col-md-4 mb-4">
                                        <!-- Tarjeta de producto con borde y sombra -->
                                        <div class="card shadow border border-info h-100">
                                            <!-- Imagen del producto con carga lazy -->
                                            <img src="<?= base_url('public/' . $favorito['imagen']) ?>" 
                                                class="card-img-top imagen-producto" 
                                                alt="<?= esc($favorito['nombre']); ?>"
                                                loading="lazy">
                                            <!-- Cuerpo de la tarjeta con información del producto -->
                                            <div class="card-body d-flex flex-column">
                                                <!-- Nombre del producto con escape para seguridad -->
                                                <h5 class="card-title text-info"><?= esc($favorito['nombre']); ?></h5>
                                                <!-- Etiqueta de categoría -->
                                                <span class="badge bg-info text-dark mb-2"><?= esc($favorito['categoria']); ?></span>
                                                <!-- Contenedor con precio y botones de acción -->
                                                <div class="mt-auto">
                                                    <!-- Precio formateado con separadores de miles -->
                                                    <p class="card-text text-info mb-3">$<?= number_format($favorito['precio_vta'], 2, ',', '.'); ?></p>
                                                    <!-- Botones de acción en columna -->
                                                    <div class="d-flex flex-column gap-2">
                                                        <!-- Botón para ver detalle del producto -->
                                                        <a href="<?= base_url('producto/detalle/' . $favorito['producto_id']); ?>" 
                                                            class="btn btn-info text-black rounded-pill">
                                                            <i class="fas fa-eye me-2"></i>Ver detalle
                                                        </a>
                                                        <!-- Botón para eliminar de favoritos -->
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
                        <!-- Mensaje cuando no hay favoritos -->
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