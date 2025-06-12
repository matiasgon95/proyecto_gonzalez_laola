<?= $this->extend('front/layout/layouts') ?>
<?= $this->section('contenedor') ?>

<div class="container-fluid py-5 bg-dark text-info">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card bg-dark border-info mb-4">
                    <div class="card-body text-info">
                        <h1 class="display-4 text-center mb-4">Panel de Administración</h1>
                        <p class="lead text-center mb-4">Bienvenido, <?= session('usuario_nombre') ?> 
                            <span class="badge bg-info text-dark ms-2">Administrador</span>
                        </p>
                    </div>
                </div>

                <div class="row g-4">
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
                    
                    <!-- Nuevo menú para consultas -->
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

                <div class="text-center mt-5">
                    <a href="<?= base_url('LoginController/logout') ?>" class="btn btn-outline-danger btn-lg">
                        <i class="fas fa-power-off me-2"></i>Cerrar Sesión
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
