<?= $this->extend('front/layouts'); ?>

<?= $this->section('contenedor'); ?>

<h1>Bienvenido, <?= session()->get('usuario_nombre'); ?>!</h1>

    <p>Has iniciado sesión correctamente.</p>

    <p><a href="<?= site_url('login_controller/logout') ?>">Cerrar sesión</a></p>

<?= $this->endSection(); ?>