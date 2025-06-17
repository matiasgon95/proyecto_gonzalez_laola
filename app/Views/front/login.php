<?= $this->extend('front/layout/layouts'); ?>
<?= $this->section('contenedor'); ?>

<!-- Sección principal: Formulario de login -->
<div class="container-fluid py-5 bg-dark text-info">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card bg-dark border-info">
                    <div class="card-body">
                        <h3 class="text-center mb-4">Iniciar sesión</h3>
                        
                        <!-- Mensajes de alerta (éxito/error) -->
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

                        <!-- Formulario de login -->
                        <form action="<?= base_url('LoginController/autenticar') ?>" method="post">
                            <?= csrf_field() ?>

                            <!-- Campo de email -->
                            <div class="mb-3">
                                <label for="email" class="form-label">Correo electrónico</label>
                                <input type="email" class="form-control bg-dark text-info border-info" name="email" id="email" required autofocus>
                            </div>

                            <!-- Campo de contraseña con botón para mostrar/ocultar -->
                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <div class="input-group">
                                    <input type="password" class="form-control bg-dark text-info border-info" name="pass" id="pass" required>
                                    <button class="btn btn-outline-info" type="button" id="togglePassword">
                                        <i class="fas fa-eye" id="eyeIcon"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Botón de ingreso -->
                            <button type="submit" class="btn btn-outline-info w-100 mb-4 py-2 fw-bold hover-scale">
                                <i class="fas fa-sign-in-alt me-2"></i>Ingresar
                            </button>
                            
                            <!-- Enlace para registro de usuario -->
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