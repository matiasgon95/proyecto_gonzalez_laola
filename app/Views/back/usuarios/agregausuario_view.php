<?= $this->extend('front/layout/layouts') ?>
<?= $this->section('contenedor') ?>

<div class="container py-5 bg-dark text-info">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card bg-dark border-info">
                <div class="card-body">
                    <h2 class="text-center mb-4">Agregar Nuevo Administrador</h2>
                    
                    <?php if(session()->has('errors')): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach(session('errors') as $error): ?>
                                    <li><?= $error ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    
                    <form method="post" action="<?= site_url('admin/usuarios/guardar') ?>" class="needs-validation">
                        <?= csrf_field() ?>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control bg-dark text-info border-info" id="nombre" name="nombre" value="<?= old('nombre') ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="apellido" class="form-label">Apellido</label>
                                <input type="text" class="form-control bg-dark text-info border-info" id="apellido" name="apellido" value="<?= old('apellido') ?>" required>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control bg-dark text-info border-info" id="email" name="email" value="<?= old('email') ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="pass" class="form-label">Contraseña</label>
                                <input type="password" class="form-control bg-dark text-info border-info" id="pass" name="pass" required>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="provincia" class="form-label">Provincia</label>
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
                        </div>
                        
                        <!-- Campo oculto para establecer el perfil como administrador -->
                        <input type="hidden" name="perfil_id" value="1">
                        <!-- Campo oculto para establecer el estado como activo -->
                        <input type="hidden" name="baja" value="no">
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <a href="<?= site_url('admin/usuarios') ?>" class="btn btn-secondary me-md-2">
                                <i class="fas fa-times"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Guardar
                            </button>
                        </div>
                        <!-- Justo después de la etiqueta <form> agrega esta línea -->
                        <?= csrf_field() ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
