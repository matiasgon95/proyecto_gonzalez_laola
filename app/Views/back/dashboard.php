<?= $this->extend('front/layout/layouts') ?> <!-- Extiende la plantilla principal -->
<?= $this->section('contenedor') ?> <!-- Inicia la sección de contenido -->

<!-- Panel principal de administración -->
<div class="container-fluid py-5 bg-dark text-info">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Encabezado del panel con saludo al usuario -->
                <div class="card bg-dark border-info mb-4">
                    <div class="card-body text-info">
                        <h1 class="admin-panel-title text-center mb-4">Panel de Administración</h1>
                        <p class="lead text-center mb-4">Bienvenido, <?= session('usuario_nombre') ?> 
                            <span class="badge bg-info text-dark ms-2">Administrador</span>
                        </p>
                    </div>
                </div>

                <!-- Tarjetas de navegación a las diferentes secciones del panel -->
                <div class="row g-4">
                    <!-- Tarjeta de Gestión de Usuarios -->
                    <div class="col-md-6 col-lg-3">
                        <div class="card h-100 bg-dark border-info dashboard-card">
                            <div class="card-body text-center">
                                <a href="<?= base_url('admin/usuarios') ?>" class="text-decoration-none text-info dashboard-link">
                                    <i class="fas fa-users fa-3x mb-3"></i>
                                    <h5 class="card-title">Gestión de Usuarios</h5>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Tarjeta de Gestión de Productos -->
                    <div class="col-md-6 col-lg-3">
                        <div class="card h-100 bg-dark border-info dashboard-card">
                            <div class="card-body text-center">
                                <a href="<?= base_url('back/productos') ?>" class="text-decoration-none text-info dashboard-link">
                                    <i class="fas fa-box fa-3x mb-3"></i>
                                    <h5 class="card-title">Gestión de Productos</h5>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Tarjeta de Pedidos -->
                    <div class="col-md-6 col-lg-2">
                        <div class="card h-100 bg-dark border-info dashboard-card">
                            <div class="card-body text-center">
                                <a href="<?= base_url('back/pedidos') ?>" class="text-decoration-none text-info dashboard-link">
                                    <i class="fas fa-shopping-cart fa-3x mb-3"></i>
                                    <h5 class="card-title">Pedidos</h5>
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tarjeta de Consultas -->
                    <div class="col-md-6 col-lg-2">
                        <div class="card h-100 bg-dark border-info dashboard-card">
                            <div class="card-body text-center">
                                <a href="<?= base_url('back/consultas') ?>" class="text-decoration-none text-info dashboard-link">
                                    <i class="fas fa-envelope fa-3x mb-3"></i>
                                    <h5 class="card-title">Consultas</h5>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Tarjeta de Estadísticas -->
                    <div class="col-md-6 col-lg-2">
                        <div class="card h-100 bg-dark border-info dashboard-card">
                            <div class="card-body text-center">
                                <a href="<?= base_url('back/estadisticas') ?>" class="text-decoration-none text-info dashboard-link">
                                    <i class="fas fa-chart-line fa-3x mb-3"></i>
                                    <h5 class="card-title" style="font-size: 1.2rem;">Estadísticas</h5>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botón de cierre de sesión -->
                <div class="text-center mt-5">
                    <a href="<?= base_url('LoginController/logout') ?>" class="btn btn-outline-danger btn-lg">
                        <i class="fas fa-power-off me-2"></i>Cerrar Sesión
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?> <!-- Finaliza la sección de contenido -->
