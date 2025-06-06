<?= $this->extend('front/layout/layouts') ?>
<?= $this->section('contenedor') ?>

<div class="container py-5 bg-dark text-info">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card bg-dark border-info">
                <div class="card-body">
                    <h2 class="text-center mb-4">Editar Administrador</h2>
                    
                    <?php if(session()->has('errors')): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach(session('errors') as $error): ?>
                                    <li><?= $error ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    
                    <form method="post" action="<?= site_url('admin/usuarios/actualizar/' . $usuario->id) ?>" class="needs-validation">
                        <?= csrf_field() ?>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control bg-dark text-info border-info" id="nombre" name="nombre" value="<?= $usuario->nombre ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="apellido" class="form-label">Apellido</label>
                                <input type="text" class="form-control bg-dark text-info border-info" id="apellido" name="apellido" value="<?= $usuario->apellido ?>" required>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control bg-dark text-info border-info" id="email" name="email" value="<?= $usuario->email ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="pass" class="form-label">Contraseña (dejar en blanco si no cambia)</label>
                                <input type="password" class="form-control bg-dark text-info border-info" id="pass" name="pass">
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="provincia" class="form-label">Provincia</label>
                                <select class="form-select bg-dark text-info border-info" name="provincia" id="provincia" required>
                                    <option value="" disabled>Seleccione una provincia</option>
                                    <option value="Buenos Aires" <?= ($usuario->provincia == 'Buenos Aires') ? 'selected' : '' ?>>Buenos Aires</option>
                                    <option value="Ciudad Autónoma de Buenos Aires" <?= ($usuario->provincia == 'Ciudad Autónoma de Buenos Aires') ? 'selected' : '' ?>>Ciudad Autónoma de Buenos Aires</option>
                                    <option value="Catamarca" <?= ($usuario->provincia == 'Catamarca') ? 'selected' : '' ?>>Catamarca</option>
                                    <option value="Chaco" <?= ($usuario->provincia == 'Chaco') ? 'selected' : '' ?>>Chaco</option>
                                    <option value="Chubut" <?= ($usuario->provincia == 'Chubut') ? 'selected' : '' ?>>Chubut</option>
                                    <option value="Córdoba" <?= ($usuario->provincia == 'Córdoba') ? 'selected' : '' ?>>Córdoba</option>
                                    <option value="Corrientes" <?= ($usuario->provincia == 'Corrientes') ? 'selected' : '' ?>>Corrientes</option>
                                    <option value="Entre Ríos" <?= ($usuario->provincia == 'Entre Ríos') ? 'selected' : '' ?>>Entre Ríos</option>
                                    <option value="Formosa" <?= ($usuario->provincia == 'Formosa') ? 'selected' : '' ?>>Formosa</option>
                                    <option value="Jujuy" <?= ($usuario->provincia == 'Jujuy') ? 'selected' : '' ?>>Jujuy</option>
                                    <option value="La Pampa" <?= ($usuario->provincia == 'La Pampa') ? 'selected' : '' ?>>La Pampa</option>
                                    <option value="La Rioja" <?= ($usuario->provincia == 'La Rioja') ? 'selected' : '' ?>>La Rioja</option>
                                    <option value="Mendoza" <?= ($usuario->provincia == 'Mendoza') ? 'selected' : '' ?>>Mendoza</option>
                                    <option value="Misiones" <?= ($usuario->provincia == 'Misiones') ? 'selected' : '' ?>>Misiones</option>
                                    <option value="Neuquén" <?= ($usuario->provincia == 'Neuquén') ? 'selected' : '' ?>>Neuquén</option>
                                    <option value="Río Negro" <?= ($usuario->provincia == 'Río Negro') ? 'selected' : '' ?>>Río Negro</option>
                                    <option value="Salta" <?= ($usuario->provincia == 'Salta') ? 'selected' : '' ?>>Salta</option>
                                    <option value="San Juan" <?= ($usuario->provincia == 'San Juan') ? 'selected' : '' ?>>San Juan</option>
                                    <option value="San Luis" <?= ($usuario->provincia == 'San Luis') ? 'selected' : '' ?>>San Luis</option>
                                    <option value="Santa Cruz" <?= ($usuario->provincia == 'Santa Cruz') ? 'selected' : '' ?>>Santa Cruz</option>
                                    <option value="Santa Fe" <?= ($usuario->provincia == 'Santa Fe') ? 'selected' : '' ?>>Santa Fe</option>
                                    <option value="Santiago del Estero" <?= ($usuario->provincia == 'Santiago del Estero') ? 'selected' : '' ?>>Santiago del Estero</option>
                                    <option value="Tierra del Fuego" <?= ($usuario->provincia == 'Tierra del Fuego') ? 'selected' : '' ?>>Tierra del Fuego</option>
                                    <option value="Tucumán" <?= ($usuario->provincia == 'Tucumán') ? 'selected' : '' ?>>Tucumán</option>
                                </select>
                            </div>
                        </div>
                        
                        <!-- Después de los otros campos ocultos -->
                        <input type="hidden" name="perfil_id" value="1">
                        <input type="hidden" name="baja" value="no">
                        <input type="hidden" name="usuario" value="<?= $usuario->email ?>">  <!-- Añadir esta línea -->
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <a href="<?= site_url('admin/usuarios') ?>" class="btn btn-secondary me-md-2">
                                <i class="fas fa-times"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save"></i> Actualizar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
