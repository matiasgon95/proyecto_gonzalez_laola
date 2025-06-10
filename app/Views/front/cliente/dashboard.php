<?= $this->extend('front/layout/layouts'); ?>

<?= $this->section('contenedor'); ?>

<div class="container-fluid py-5 bg-dark text-info">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card bg-dark border-info mb-4">
                    <div class="card-body text-info">
                        <h1 class="display-4 text-center mb-4">Panel de Cliente</h1>
                        <p class="lead text-center mb-4">Bienvenido, <?= session()->get('usuario_nombre'); ?> 
                            <span class="badge bg-info text-dark ms-2">Cliente</span>
                        </p>
                    </div>
                </div>

                <div class="row g-4">
                    <div class="col-md-6 col-lg-3">
                        <div class="card h-100 bg-dark border-info dashboard-card">
                            <div class="card-body text-center">
                                <a href="<?= base_url('front/cliente/perfil') ?>" class="text-decoration-none text-info dashboard-link">
                                    <i class="fas fa-user fa-3x mb-3"></i>
                                    <h5 class="card-title">Mi Perfil</h5>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3">
                        <div class="card h-100 bg-dark border-info dashboard-card">
                            <div class="card-body text-center">
                                <a href="<?= base_url('productos') ?>" class="text-decoration-none text-info dashboard-link">
                                    <i class="fas fa-shopping-cart fa-3x mb-3"></i>
                                    <h5 class="card-title">Comprar Productos</h5>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3">
                        <div class="card h-100 bg-dark border-info dashboard-card">
                            <div class="card-body text-center">
                                <a href="<?= base_url('front/cliente/pedidos') ?>" class="text-decoration-none text-info dashboard-link">
                                    <i class="fas fa-box fa-3x mb-3"></i>
                                    <h5 class="card-title">Mis Pedidos</h5>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3">
                        <div class="card h-100 bg-dark border-info dashboard-card">
                            <div class="card-body text-center">
                                <a href="#" class="text-decoration-none text-info dashboard-link">
                                    <i class="fas fa-heart fa-3x mb-3"></i>
                                    <h5 class="card-title">Favoritos</h5>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-5">
                    <a href="<?= site_url('LoginController/logout') ?>" class="btn btn-outline-danger btn-lg">
                        <i class="fas fa-power-off me-2"></i>Cerrar Sesión
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Agregar estilos específicos para las tarjetas del dashboard -->
<style>
.dashboard-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    cursor: pointer;
}

.dashboard-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 10px 25px rgba(0, 188, 212, 0.3);
}

.dashboard-link {
    display: block;
    width: 100%;
    height: 100%;
}

.dashboard-link i {
    transition: transform 0.3s ease, color 0.3s ease;
}

.dashboard-card:hover .dashboard-link i {
    transform: scale(1.2);
    color: #00bcd4;
}
</style>

<?= $this->endSection(); ?>