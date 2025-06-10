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
                                <div class="input-group">
                                    <input type="password" class="form-control bg-dark text-info border-info" name="pass" id="pass" required>
                                    <button class="btn btn-outline-info" type="button" id="togglePassword">
                                        <i class="fas fa-eye" id="toggleIcon"></i>
                                    </button>
                                </div>
                                <div class="form-text text-info small mt-1">
                                    La contraseña debe tener entre 8 y 16 caracteres, incluir al menos una letra mayúscula y un número.
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="provincia" class="form-label"><i class="fas fa-map-marker-alt me-2"></i>Provincia</label>
                                <select class="form-select bg-dark text-info border-info" name="provincia" id="provincia" required>
                                    <option value="">Seleccione una provincia</option>
                                    <?php $selectedProvincia = old('provincia'); ?>
                                    <option value="Buenos Aires" <?= ($selectedProvincia == 'Buenos Aires') ? 'selected' : '' ?>>Buenos Aires</option>
                                    <option value="Ciudad Autónoma de Buenos Aires" <?= ($selectedProvincia == 'Ciudad Autónoma de Buenos Aires') ? 'selected' : '' ?>>Ciudad Autónoma de Buenos Aires</option>
                                    <option value="Catamarca" <?= ($selectedProvincia == 'Catamarca') ? 'selected' : '' ?>>Catamarca</option>
                                    <option value="Chaco" <?= ($selectedProvincia == 'Chaco') ? 'selected' : '' ?>>Chaco</option>
                                    <option value="Chubut" <?= ($selectedProvincia == 'Chubut') ? 'selected' : '' ?>>Chubut</option>
                                    <option value="Córdoba" <?= ($selectedProvincia == 'Córdoba') ? 'selected' : '' ?>>Córdoba</option>
                                    <option value="Corrientes" <?= ($selectedProvincia == 'Corrientes') ? 'selected' : '' ?>>Corrientes</option>
                                    <option value="Entre Ríos" <?= ($selectedProvincia == 'Entre Ríos') ? 'selected' : '' ?>>Entre Ríos</option>
                                    <option value="Formosa" <?= ($selectedProvincia == 'Formosa') ? 'selected' : '' ?>>Formosa</option>
                                    <option value="Jujuy" <?= ($selectedProvincia == 'Jujuy') ? 'selected' : '' ?>>Jujuy</option>
                                    <option value="La Pampa" <?= ($selectedProvincia == 'La Pampa') ? 'selected' : '' ?>>La Pampa</option>
                                    <option value="La Rioja" <?= ($selectedProvincia == 'La Rioja') ? 'selected' : '' ?>>La Rioja</option>
                                    <option value="Mendoza" <?= ($selectedProvincia == 'Mendoza') ? 'selected' : '' ?>>Mendoza</option>
                                    <option value="Misiones" <?= ($selectedProvincia == 'Misiones') ? 'selected' : '' ?>>Misiones</option>
                                    <option value="Neuquén" <?= ($selectedProvincia == 'Neuquén') ? 'selected' : '' ?>>Neuquén</option>
                                    <option value="Río Negro" <?= ($selectedProvincia == 'Río Negro') ? 'selected' : '' ?>>Río Negro</option>
                                    <option value="Salta" <?= ($selectedProvincia == 'Salta') ? 'selected' : '' ?>>Salta</option>
                                    <option value="San Juan" <?= ($selectedProvincia == 'San Juan') ? 'selected' : '' ?>>San Juan</option>
                                    <option value="San Luis" <?= ($selectedProvincia == 'San Luis') ? 'selected' : '' ?>>San Luis</option>
                                    <option value="Santa Cruz" <?= ($selectedProvincia == 'Santa Cruz') ? 'selected' : '' ?>>Santa Cruz</option>
                                    <option value="Santa Fe" <?= ($selectedProvincia == 'Santa Fe') ? 'selected' : '' ?>>Santa Fe</option>
                                    <option value="Santiago del Estero" <?= ($selectedProvincia == 'Santiago del Estero') ? 'selected' : '' ?>>Santiago del Estero</option>
                                    <option value="Tierra del Fuego" <?= ($selectedProvincia == 'Tierra del Fuego') ? 'selected' : '' ?>>Tierra del Fuego</option>
                                    <option value="Tucumán" <?= ($selectedProvincia == 'Tucumán') ? 'selected' : '' ?>>Tucumán</option>
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
