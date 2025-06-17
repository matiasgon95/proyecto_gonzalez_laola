<?= $this->extend('front/layout/layouts') ?> <!-- Extiende la plantilla principal de layouts -->
<?= $this->section('contenedor') ?> <!-- Inicia la sección 'contenedor' que se insertará en la plantilla -->

<!-- Contenedor principal con fondo oscuro y texto en color info (azul claro) -->
<div class="container-fluid py-5 bg-dark text-info">
    <div class="container">
        <div class="row justify-content-center">
            <!-- Reducimos el ancho del contenedor principal a col-lg-10 para mejor legibilidad -->
            <div class="col-lg-10"> 
                <!-- Panel superior con título y bienvenida, limitado a 800px de ancho -->
                <div class="card bg-dark border-info mb-4 mx-auto" style="max-width: 800px;">
                    <div class="card-body text-info">
                        <h1 class="display-4 text-center mb-4">Panel de Cliente</h1>
                        <!-- Muestra el nombre del usuario desde la sesión -->
                        <p class="lead text-center mb-4">Bienvenido, <?= session()->get('usuario_nombre') ?> 
                            <span class="badge bg-info text-dark ms-2">Cliente</span>
                        </p>
                    </div>
                </div>

                <!-- Contenedor de tarjetas de navegación con el mismo ancho máximo que el panel superior -->
                <div class="mx-auto" style="max-width: 800px;">
                    <!-- Grid de tarjetas con espaciado y distribución uniforme -->
                    <div class="row g-3 justify-content-between"> 
                        <!-- Tarjeta de Mi Perfil - Responsive: 2 columnas en móvil, 3 en tablet, 5 en desktop -->
                        <div class="col-6 col-md-4 col-lg">
                            <div class="card h-100 bg-dark border-info dashboard-card">
                                <div class="card-body text-center">
                                    <a href="<?= base_url('front/cliente/perfil') ?>" class="text-decoration-none text-info dashboard-link">
                                        <i class="fas fa-user fa-3x mb-3"></i>
                                        <h5 class="card-title">Mi Perfil</h5>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Tarjeta de Comprar - Enlace a la tienda de productos -->
                        <div class="col-6 col-md-4 col-lg">
                            <div class="card h-100 bg-dark border-info dashboard-card">
                                <div class="card-body text-center">
                                    <a href="<?= base_url('productos') ?>" class="text-decoration-none text-info dashboard-link">
                                        <i class="fas fa-shopping-cart fa-3x mb-3"></i>
                                        <h5 class="card-title">Comprar</h5>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Tarjeta de Mis Pedidos - Historial de compras del cliente -->
                        <div class="col-6 col-md-4 col-lg">
                            <div class="card h-100 bg-dark border-info dashboard-card">
                                <div class="card-body text-center">
                                    <a href="<?= base_url('front/cliente/pedidos') ?>" class="text-decoration-none text-info dashboard-link">
                                        <i class="fas fa-box fa-3x mb-3"></i>
                                        <h5 class="card-title">Mis Pedidos</h5>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Tarjeta de Favoritos - Productos marcados como favoritos -->
                        <div class="col-6 col-md-4 col-lg">
                            <div class="card h-100 bg-dark border-info dashboard-card">
                                <div class="card-body text-center">
                                    <a href="<?= base_url('front/cliente/favoritos') ?>" class="text-decoration-none text-info dashboard-link">
                                        <i class="fas fa-heart fa-3x mb-3"></i>
                                        <h5 class="card-title">Favoritos</h5>
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Tarjeta de Consultas - Sistema de mensajería/soporte -->
                        <div class="col-6 col-md-4 col-lg">
                            <div class="card h-100 bg-dark border-info dashboard-card">
                                <div class="card-body text-center">
                                    <a href="<?= base_url('front/cliente/consultas') ?>" class="text-decoration-none text-info dashboard-link">
                                        <i class="fas fa-comments fa-3x mb-3"></i>
                                        <h5 class="card-title">Consultas</h5>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botón de cierre de sesión centrado y separado de las tarjetas -->
                <div class="text-center mt-5">
                    <a href="<?= base_url('LoginController/logout') ?>" class="btn btn-outline-danger btn-lg">
                        <i class="fas fa-power-off me-2"></i>Cerrar Sesión
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?> <!-- Finaliza la sección 'contenedor' -->