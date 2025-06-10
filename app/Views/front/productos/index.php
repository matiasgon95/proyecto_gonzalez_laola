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
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="text-info mb-0">Catálogo de Productos</h1>
                
                <!-- Selector de ordenación -->
                <div class="dropdown">
                    <button class="btn btn-outline-info dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-sort me-1"></i> Ordenar por: 
                        <?php 
                        $textoOrden = 'Predeterminado';
                        if (isset($orden_actual)) {
                            switch ($orden_actual) {
                                case 'precio_asc': $textoOrden = 'Precio: menor a mayor'; break;
                                case 'precio_desc': $textoOrden = 'Precio: mayor a menor'; break;
                                case 'mas_vendidos': $textoOrden = 'Más vendidos'; break;
                            }
                        }
                        echo $textoOrden;
                        ?>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                        <?php 
                        // Determinar la URL base para los enlaces de ordenación
                        $urlBase = isset($categoria_actual) 
                            ? base_url('producto/categoria/' . urlencode($categoria_actual)) 
                            : base_url('productos');
                        ?>
                        <li><a class="dropdown-item" href="<?= $urlBase . '?orden=mas_vendidos' ?>">Más vendidos</a></li>
                        <li><a class="dropdown-item" href="<?= $urlBase . '?orden=precio_asc' ?>">Precio: menor a mayor</a></li>
                        <li><a class="dropdown-item" href="<?= $urlBase . '?orden=precio_desc' ?>">Precio: mayor a menor</a></li>
                    </ul>
                </div>
            </div>
            
            <?php if(isset($termino_busqueda)): ?>
            <div class="alert alert-info mb-4">
                <i class="fas fa-search me-2"></i> Resultados para: <strong><?= esc($termino_busqueda) ?></strong>
                <a href="<?= base_url('productos') ?>" class="float-end"><i class="fas fa-times"></i> Limpiar búsqueda</a>
            </div>
            <?php endif; ?>
            
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
                                    <span class="badge bg-info text-dark mb-2"><?= esc($producto['categoria']); ?></span>
                                    <div class="mt-auto">
                                        <p class="card-text text-info mb-3">$<?= number_format($producto['precio_vta'], 2, ',', '.'); ?></p>
                                        <div class="d-flex flex-column gap-2">
                                            <a href="<?= base_url('producto/detalle/' . $producto['id']); ?>" 
                                                class="btn btn-info text-black rounded-pill">
                                                <i class="fas fa-eye me-2"></i>Ver detalle
                                            </a>
                                            
                                            <?php if(session()->get('usuario_id')): ?>
                                            <!-- Formulario para agregar a favoritos -->
                                            <form action="<?= base_url('front/cliente/agregar_favorito') ?>" method="post" class="mb-2">
                                                <input type="hidden" name="producto_id" value="<?= $producto['id'] ?>">
                                                <button type="submit" class="btn btn-outline-info rounded-pill w-100 favorito-btn" data-producto-id="<?= $producto['id'] ?>">
                                                    <i class="far fa-heart me-2"></i>Agregar a favoritos
                                                </button>
                                            </form>
                                            <?php endif; ?>
                                            
                                            <!-- Formulario para agregar al carrito -->
                                            <form action="<?= base_url('carrito_agrega') ?>" method="post">
                                                <input type="hidden" name="id" value="<?= $producto['id'] ?>">
                                                <input type="hidden" name="name" value="<?= $producto['nombre'] ?>">
                                                <input type="hidden" name="price" value="<?= $producto['precio_vta'] ?>">
                                                <input type="hidden" name="imagen" value="<?= $producto['imagen'] ?>">
                                                <button type="submit" class="btn btn-outline-info rounded-pill w-100">
                                                    <i class="fas fa-shopping-cart me-2"></i>Agregar al carrito
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    
                    <!-- Agregar los enlaces de paginación -->
                    <div class="col-12 mt-4">
                        <div class="d-flex justify-content-center">
                            <?php if (isset($pager)): ?>
                                <?= $pager->only(['orden'])->links('default', 'bootstrap_pagination') ?>
                            <?php endif; ?>
                        </div>
                    </div>
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