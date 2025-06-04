<?= $this->extend('front/layout/layouts') ?>
<?= $this->section('contenedor') ?>

<div class="admin-dashboard">
    <div class="dashboard-header">
        <h1 class="cyber-title">Panel de Administración</h1>
        <p class="user-welcome">Bienvenido, <?= session('usuario_nombre') ?> <span class="role-badge">Administrador</span></p>
    </div>

    <div class="admin-menu">
        <div class="menu-item">
            <a href="#" class="menu-link">
                <i class="fas fa-users"></i>
                <span>Gestión de Usuarios</span>
            </a>
        </div>

        <div class="menu-item">
            <a href="<?= base_url('back/productos') ?>" class="menu-link">
                <i class="fas fa-box"></i>
                <span>Gestión de Productos</span>
            </a>
        </div>

        <div class="menu-item">
            <a href="#" class="menu-link">
                <i class="fas fa-shopping-cart"></i>
                <span>Pedidos</span>
            </a>
        </div>

        <div class="menu-item">
            <a href="#" class="menu-link">
                <i class="fas fa-chart-line"></i>
                <span>Estadísticas</span>
            </a>
        </div>
    </div>

    <div class="logout-section">
        <a href="<?= base_url('LoginController/logout') ?>" class="logout-btn">
            <i class="fas fa-power-off"></i>
            <span>Cerrar Sesión</span>
        </a>
    </div>
</div>

<?= $this->endSection() ?>
