<?= $this->extend('front/layout/layouts'); ?>

<?= $this->section('contenedor'); ?>
<div class="container producto-detalle-container my-5">
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
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Guardar la posición actual de la página
        const currentPosition = window.scrollY;
        
        // Configurar el toast para que se cierre automáticamente después de 5 segundos
        setTimeout(function() {
            const toast = document.querySelector('.toast');
            const bsToast = new bootstrap.Toast(toast);
            bsToast.hide();
        }, 5000);
        
        // Restaurar la posición de desplazamiento
        window.scrollTo(0, currentPosition);
        
        // Abrir el modal del carrito al hacer clic en el botón del toast
        document.getElementById('openCartModalBtn').addEventListener('click', function() {
            const cartModal = document.getElementById('cartModal');
            cartModal.classList.add('show');
            // Cargar el contenido del carrito
            fetch(baseUrl + 'carrito/mini')
                .then(response => response.text())
                .then(data => {
                    document.getElementById('cartModalBody').innerHTML = data;
                    // Configurar los botones del carrito
                    if (typeof setupCartButtons === 'function') {
                        setupCartButtons();
                    } else {
                        // Si la función no está disponible, cargar el script y ejecutarla
                        const script = document.createElement('script');
                        script.src = baseUrl + 'assets/js/cart.js';
                        script.onload = function() {
                            if (typeof setupCartButtons === 'function') {
                                setupCartButtons();
                            }
                        };
                        document.head.appendChild(script);
                    }
                });
        });
    });
    </script>
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
                    <form action="<?= base_url('carrito_agrega'); ?>" method="post">
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
                            
                            <?php if(session()->has('usuario_id')): ?>
                                <!-- Separar el formulario de favoritos del formulario de carrito -->
                            </form>
                            <form action="<?= base_url('front/cliente/agregar_favorito'); ?>" method="post" class="d-inline favorito-form">
                                <?= csrf_field() ?>
                                <input type="hidden" name="producto_id" value="<?= $producto['id']; ?>">
                                <button type="submit" class="btn btn-outline-danger favorito-btn">
                                    <i class="fas fa-heart me-2"></i>Añadir a favoritos
                                </button>
                            </form>
                            <?php else: ?>
                            </form>
                            <?php endif; ?>
                            
                            <a href="<?= base_url('productos'); ?>" class="btn btn-outline-secondary btn-volver">
                                <i class="fas fa-arrow-left me-2"></i>Volver al catálogo
                            </a>
                        </div>
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
