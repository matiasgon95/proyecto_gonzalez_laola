<?= $this->extend('front/layout/layouts'); ?>

<?= $this->section('contenedor'); ?>
<div class="container py-4">
    <!-- Mostrar mensaje Flash si existe como toast -->
    <?php if (session()->getFlashdata('mensaje')): ?>
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1100">
        <div class="toast show bg-dark" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-info text-dark">
                <i class="fas fa-info-circle me-2"></i>
                <strong class="me-auto">Notificación</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Cerrar"></button>
            </div>
            <div class="toast-body text-light">
                <div class="d-flex flex-column">
                    <div class="mb-2">
                        <?= session()->getFlashdata('mensaje') ?>
                    </div>
                    <button type="button" class="btn btn-info btn-sm align-self-end" id="openCartModalBtn">
                        <i class="fas fa-shopping-cart me-1"></i>Ver carrito
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    
    <div class="row">
        <!-- Barra lateral de categorías -->
        <div class="col-md-3">
            <div class="sidebar shadow-sm">
                <div class="d-flex justify-content-between align-items-center">
                    <h3>Categorías</h3>
                    <button class="btn btn-sm btn-info toggle-categories" id="toggleCategories">
                        <i class="fas fa-chevron-up" id="categoryIcon"></i>
                    </button>
                </div>
                <ul class="list-group" id="categoriesList">
                    <!-- Opción para ver todos los productos -->
                    <li class="list-group-item">
                        <a href="<?= base_url('productos'); ?>" class="d-flex justify-content-between align-items-center">
                            <span>Ver todos los productos</span>
                            <i class="fas fa-list text-info"></i>
                        </a>
                    </li>
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
            
            <?php if(isset($termino_busqueda)): ?>
            <div class="alert alert-info mb-4">
                <i class="fas fa-search me-2"></i> Resultados para: <strong><?= esc($termino_busqueda) ?></strong>
                <a href="<?= base_url('productos') ?>" class="float-end"><i class="fas fa-times"></i> Limpiar búsqueda</a>
            </div>
            <?php endif; ?>
            
            <div class="row">
                <div class="row">
                    <?php if (!empty($productos)): ?>
                        <!-- Dentro del bucle foreach de productos, después del botón de "Ver detalle" y antes del formulario de agregar al carrito -->
                        <?php foreach ($productos as $producto): ?>
                            <div class="col-md-4 mb-4">
                                <div class="card shadow border border-info h-100">
                                    <img src="<?= base_url('public/' . $producto['imagen']) ?>" 
                                        class="card-img-top imagen-producto" 
                                        alt="<?= esc($producto['nombre']); ?>"
                                        loading="lazy">
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title text-info"><?= esc($producto['nombre']); ?></h5>
                                        <span class="badge bg-info text-dark mb-2"><?= esc($producto['categoria']); ?></span>
                                        <div class="mt-auto">
                                            <p class="card-text text-info mb-3">$<?= number_format($producto['precio_vta'], 2); ?></p>
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <a href="<?= base_url('producto/detalle/' . $producto['id']); ?>" 
                                                    class="btn btn-info text-black rounded-pill flex-grow-1 me-2">
                                                    <i class="fas fa-eye me-2"></i>Ver detalle
                                                </a>
                                                
                                                <!-- Botón de Favoritos -->
                                                <?php if(session()->has('usuario_id')): ?>
                                                    <form action="<?= base_url('front/cliente/agregar_favorito'); ?>" method="post" class="d-inline favorito-form">
                                                        <?= csrf_field() ?>
                                                        <input type="hidden" name="producto_id" value="<?= $producto['id']; ?>">
                                                        <button type="submit" class="btn btn-outline-danger rounded-circle favorito-btn" title="Agregar a favoritos">
                                                            <i class="fas fa-heart"></i>
                                                        </button>
                                                    </form>
                                                <?php endif; ?>
                                            </div>
                                            
                                            <!-- Formulario Agregar al Carrito -->
                                            <form action="<?= base_url('carrito_agrega'); ?>" method="post">
                                                <?= csrf_field() ?>
                                                <input type="hidden" name="id" value="<?= $producto['id']; ?>">
                                                <input type="hidden" name="nombre_prod" value="<?= $producto['nombre']; ?>">
                                                <input type="hidden" name="precio_vta" value="<?= $producto['precio_vta']; ?>">
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
</div>
<?= $this->endSection(); ?>
