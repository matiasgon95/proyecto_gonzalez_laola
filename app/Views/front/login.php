<?= $this->extend('front/layout/layouts'); ?>
<?= $this->section('contenedor'); ?>

<div class="container-fluid py-5 bg-dark text-info">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card bg-dark border-info">
                    <div class="card-body">
                        <h3 class="text-center mb-4">Iniciar sesión</h3>
                        
                        <?php if (session()->getFlashdata('success')): ?>
                            <div class="alert alert-success">
                                <?= session()->getFlashdata('success') ?>
                            </div>
                        <?php endif; ?>
                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger">
                                <?= session()->getFlashdata('error') ?>
                            </div>
                        <?php endif; ?>

                        <form action="<?= base_url('LoginController/autenticar') ?>" method="post">
                            <?= csrf_field() ?>

                            <div class="mb-3">
                                <label for="email" class="form-label">Correo electrónico</label>
                                <input type="email" class="form-control bg-dark text-info border-info" name="email" id="email" required autofocus>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <div class="input-group">
                                    <input type="password" class="form-control bg-dark text-info border-info" name="pass" id="pass" required>
                                    <button class="btn btn-outline-info" type="button" id="togglePassword">
                                        <i class="fas fa-eye" id="eyeIcon"></i>
                                    </button>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-outline-info w-100 mb-4 py-2 fw-bold hover-scale">
                                <i class="fas fa-sign-in-alt me-2"></i>Ingresar
                            </button>
                            
                            <div class="text-center">
                                <a href="registro_usuario" class="text-info text-decoration-none position-relative link-hover-effect">
                                    <i class="fas fa-user-plus me-1"></i>Registrar Usuario
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
<style>
.hover-scale {
    transition: transform 0.2s ease;
}

.hover-scale:hover {
    transform: scale(1.02);
}

.link-hover-effect {
    transition: all 0.3s ease;
}

.link-hover-effect:hover {
    color: #17a2b8 !important;
    text-shadow: 0 0 8px rgba(23, 162, 184, 0.5);
}

.link-hover-effect::after {
    content: '';
    position: absolute;
    width: 100%;
    height: 1px;
    bottom: -2px;
    left: 0;
    background-color: #17a2b8;
    transform: scaleX(0);
    transform-origin: bottom right;
    transition: transform 0.3s ease;
}

.link-hover-effect:hover::after {
    transform: scaleX(1);
    transform-origin: bottom left;
}
</style>