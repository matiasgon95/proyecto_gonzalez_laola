<?= $this->extend('front/layout/layouts') ?>
<?= $this->section('contenedor') ?>

<div class="admin-dashboard">
    <h1>Panel de Administración</h1>
    <p>Bienvenido, <?= session('usuario_nombre') ?> (Administrador)</p>

    <div class="admin-opciones">
        <ul>
            <li><a href="#">Gestión de usuarios</a></li>
            <li><a href="<?= base_url('back/productos') ?>">Gestión de productos</a></li>
            <li><a href="#">Pedidos</a></li>
            <li><a href="#">Estadísticas</a></li>
        </ul>
    </div>

    <div class="logout">
        <a href="<?= base_url('LoginController/logout') ?>" class="btn-logout">Cerrar sesión</a>
    </div>
</div>

<?= $this->endSection() ?>
