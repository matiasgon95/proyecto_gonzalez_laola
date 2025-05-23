<?= $this->extend('front/layouts'); ?>
<?= $this->section('contenedor'); ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h3 class="text-center mb-4">Registrar nuevo usuario</h3>

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

            <?php if (session('errors')): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php foreach (session('errors') as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('front/registro_usuario/guardar') ?>" method="post">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" name="nombre" id="nombre" value="<?= old('nombre') ?>" required>
                </div>

                <div class="mb-3">
                    <label for="apellido" class="form-label">Apellido</label>
                    <input type="text" class="form-control" name="apellido" id="apellido" value="<?= old('apellido') ?>" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" id="email" value="<?= old('email') ?>" required>
                </div>

                <div class="mb-3">
                    <label for="pass" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" name="pass" id="pass" required>
                </div>

                <div class="mb-3">
                    <label for="provincia" class="form-label">Provincia</label>
                    <input type="text" class="form-control" name="provincia" id="provincia" value="<?= old('provincia') ?>" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">Registrar</button>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
