<?= $this->extend('front/layout/layouts'); ?>
<?= $this->section('contenedor'); ?>


<div class="container mt-5">
        <div class="row justify-content-center">
        <div class="col-md-5">
        
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
                    <input type="email" class="form-control" name="email" id="email" required autofocus>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" name="pass" id="pass" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">Ingresar</button>
                <a href="registro_usuario">Registrar Usuario</a>
            </form>

        </div>
    </div>
</div>


<?= $this->endSection(); ?>