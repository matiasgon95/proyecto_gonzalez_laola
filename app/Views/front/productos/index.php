<?= $this->extend('front/layout/layouts'); ?>

<?= $this->section('contenedor'); ?>
<div class="container py-4">
    <!-- Sistema de notificaciones - Muestra mensajes flash como toast en la esquina inferior derecha -->
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
        <!-- Barra lateral de categorías - Permite filtrar productos por categoría -->
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

        <!-- Catálogo principal - Muestra los productos con opciones de ordenación y paginación -->
        <div class="col-md-9">
            <div class="mb-4">
                <h1 class="text-info mb-3">Catálogo de Productos</h1>
                
                <!-- Selector de ordenación - Permite ordenar productos por diferentes criterios -->
                <div class="d-flex align-items-center">
                    <span class="me-2">Ordenar por:</span>
                    <select class="form-select" style="width: auto;" id="ordenSelector">
                        <?php 
                        // Determinar la URL base para los enlaces de ordenación
                        $urlBase = isset($categoria_actual) 
                            ? base_url('producto/categoria/' . urlencode($categoria_actual)) 
                            : base_url('productos');
                            
                        // Obtener el parámetro de ordenación actual
                        $orden_actual = $orden_actual ?? 'productos.id';
                        ?>
                        <option value="<?= $urlBase . '?orden=productos.id' ?>" <?= $orden_actual == 'productos.id' ? 'selected' : '' ?>>Todos</option>
                        <option value="<?= $urlBase . '?orden=mas_vendidos' ?>" <?= $orden_actual == 'mas_vendidos' ? 'selected' : '' ?>>Más vendidos</option>
                        <option value="<?= $urlBase . '?orden=precio_asc' ?>" <?= $orden_actual == 'precio_asc' ? 'selected' : '' ?>>Precio: menor a mayor</option>
                        <option value="<?= $urlBase . '?orden=precio_desc' ?>" <?= $orden_actual == 'precio_desc' ? 'selected' : '' ?>>Precio: mayor a menor</option>
                    </select>
                </div>
            </div>
            
            <!-- Indicador de búsqueda - Muestra el término buscado y opción para limpiar -->
            <?php if(isset($termino_busqueda)): ?>
            <div class="alert alert-info mb-4">
                <i class="fas fa-search me-2"></i> Resultados para: <strong><?= esc($termino_busqueda) ?></strong>
                <a href="<?= base_url('productos') ?>" class="float-end"><i class="fas fa-times"></i> Limpiar búsqueda</a>
            </div>
            <?php endif; ?>
            
            <!-- Rejilla de productos - Muestra los productos en tarjetas responsivas -->
            <div class="row">
                <?php if (!empty($productos)): ?>
                    <?php foreach ($productos as $producto): ?>
                        <!-- Tarjeta de producto individual - Contiene imagen, información y botones de acción -->
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
                                        
                                        <!-- Indicador de stock - Muestra alerta cuando no hay stock disponible -->
                                        <?php if($producto['stock'] <= 0): ?>
                                            <div class="alert alert-danger py-1 mb-3 text-center">
                                                <i class="fas fa-exclamation-circle me-1"></i> Sin stock
                                            </div>
                                        <?php endif; ?>
                                        
                                        <!-- Botones de acción - Ver detalle, agregar a favoritos y al carrito -->
                                        <div class="d-flex flex-column gap-2">
                                            <a href="<?= base_url('producto/detalle/' . $producto['id']); ?>" 
                                                class="btn btn-info text-black rounded-pill">
                                                <i class="fas fa-eye me-2"></i>Ver detalle
                                            </a>
                                            
                                            <!-- Botón de favoritos - Solo visible para usuarios logueados -->
                                            <?php if(session()->get('usuario_id')): ?>
                                            <!-- Formulario para agregar a favoritos -->
                                            <form action="<?= base_url('front/cliente/agregar_favorito') ?>" method="post" class="mb-2">
                                                <?= csrf_field() ?>
                                                <input type="hidden" name="producto_id" value="<?= $producto['id'] ?>">
                                                <button type="submit" class="btn btn-outline-info rounded-pill w-100 favorito-btn" data-producto-id="<?= $producto['id'] ?>">
                                                    <i class="far fa-heart me-2"></i>Agregar a favoritos
                                                </button>
                                            </form>
                                            <?php endif; ?>
                                            
                                            <!-- Formulario para agregar al carrito - Se deshabilita si no hay stock -->
                                            <form action="<?= base_url('carrito_agrega') ?>" method="post">
                                                <?= csrf_field() ?>
                                                <input type="hidden" name="id" value="<?= $producto['id'] ?>">
                                                <input type="hidden" name="nombre_prod" value="<?= $producto['nombre'] ?>">  <!-- Corregido -->
                                                <input type="hidden" name="precio_vta" value="<?= $producto['precio_vta'] ?>">  <!-- Corregido -->
                                                <input type="hidden" name="imagen" value="<?= $producto['imagen'] ?>">
                                                <input type="hidden" name="qty" value="1">
                                                                            
                                                <button type="submit" class="btn btn-outline-info rounded-pill w-100" <?= ($producto['stock'] <= 0) ? 'disabled' : '' ?>>
                                                    <i class="fas fa-shopping-cart me-2"></i>Agregar al carrito
                                                </button>

                                                <!-- Mostrar stock disponible -->
                                                <div class="text-center mb-2 small <?= ($producto['stock'] <= 3) ? 'text-danger' : 'text-success' ?>">
                                                    
                                                Stock disponible: <?= $producto['stock'] ?>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    
                    <!-- Sistema de paginación - Muestra enlaces para navegar entre páginas de resultados -->
                    <div class="col-12 mt-4">
                        <div class="d-flex justify-content-center">
                            <?php if (isset($pager)): ?>
                                <?= $pager->only(['orden'])->links('default', 'bootstrap_pagination') ?>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php else: ?>
                    <!-- Mensaje cuando no hay productos - Se muestra cuando la categoría está vacía -->
                    <div class="col-12 text-center text-muted">
                        <p>No hay productos en esta categoría.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>