<?= $this->extend('front/layout/layouts'); ?>
<?= $this->section('contenedor'); ?>

<div class="container-fluid py-5 bg-dark text-info">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card bg-dark border-info">
                    <div class="card-body">
                        <h3 class="text-center mb-4">Registrar nuevo usuario</h3>

                        <?php if (session()->getFlashdata('success')): ?>
                            <div class="alert alert-success bg-success bg-opacity-25 border-success text-success">
                                <?= session()->getFlashdata('success') ?>
                            </div>
                        <?php endif; ?>

                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger bg-danger bg-opacity-25 border-danger text-danger">
                                <?= session()->getFlashdata('error') ?>
                            </div>
                        <?php endif; ?>

                        <?php if (session('errors')): ?>
                            <div class="alert alert-danger bg-danger bg-opacity-25 border-danger text-danger">
                                <ul class="mb-0">
                                    <?php foreach (session('errors') as $error): ?>
                                        <li><?= esc($error) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <form action="<?= base_url('front/registro_usuario/guardar') ?>" method="post">
                            <?= csrf_field() ?>

                            <div class="mb-3">
                                <label for="nombre" class="form-label"><i class="fas fa-user me-2"></i>Nombre</label>
                                <input type="text" class="form-control bg-dark text-info border-info" name="nombre" id="nombre" value="<?= old('nombre') ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="apellido" class="form-label"><i class="fas fa-user me-2"></i>Apellido</label>
                                <input type="text" class="form-control bg-dark text-info border-info" name="apellido" id="apellido" value="<?= old('apellido') ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label"><i class="fas fa-envelope me-2"></i>Email</label>
                                <input type="email" class="form-control bg-dark text-info border-info" name="email" id="email" value="<?= old('email') ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="pass" class="form-label"><i class="fas fa-lock me-2"></i>Contraseña</label>
                                <input type="password" class="form-control bg-dark text-info border-info" name="pass" id="pass" required>
                            </div>

                            <div class="mb-4">
                                <label for="provincia" class="form-label"><i class="fas fa-map-marker-alt me-2"></i>Provincia</label>
                                <select class="form-select bg-dark text-info border-info" name="provincia" id="provincia" required>
                                    <option value="" selected disabled>Seleccione una provincia</option>
                                    <option value="Buenos Aires">Buenos Aires</option>
                                    <option value="Ciudad Autónoma de Buenos Aires">Ciudad Autónoma de Buenos Aires</option>
                                    <option value="Catamarca">Catamarca</option>
                                    <option value="Chaco">Chaco</option>
                                    <option value="Chubut">Chubut</option>
                                    <option value="Córdoba">Córdoba</option>
                                    <option value="Corrientes">Corrientes</option>
                                    <option value="Entre Ríos">Entre Ríos</option>
                                    <option value="Formosa">Formosa</option>
                                    <option value="Jujuy">Jujuy</option>
                                    <option value="La Pampa">La Pampa</option>
                                    <option value="La Rioja">La Rioja</option>
                                    <option value="Mendoza">Mendoza</option>
                                    <option value="Misiones">Misiones</option>
                                    <option value="Neuquén">Neuquén</option>
                                    <option value="Río Negro">Río Negro</option>
                                    <option value="Salta">Salta</option>
                                    <option value="San Juan">San Juan</option>
                                    <option value="San Luis">San Luis</option>
                                    <option value="Santa Cruz">Santa Cruz</option>
                                    <option value="Santa Fe">Santa Fe</option>
                                    <option value="Santiago del Estero">Santiago del Estero</option>
                                    <option value="Tierra del Fuego">Tierra del Fuego</option>
                                    <option value="Tucumán">Tucumán</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-outline-info w-100 py-2 fw-bold hover-scale mb-3">
                                <i class="fas fa-user-plus me-2"></i>Registrar
                            </button>
                            
                            <div class="text-center">
                                <a href="<?= base_url('front/login') ?>" class="text-info text-decoration-none position-relative link-hover-effect">
                                    <i class="fas fa-sign-in-alt me-1"></i>¿Ya tienes cuenta? Inicia sesión
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
