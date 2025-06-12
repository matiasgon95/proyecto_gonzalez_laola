<?= $this->extend('front/layout/layouts'); ?>

<?= $this->section('contenedor'); ?>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow border border-info">
                <div class="card-header bg-info text-black text-center py-4">
                    <h1 class="h3 mb-2">Contacto</h1>
                    <p class="mb-0">¿Tienes preguntas sobre nuestros productos o necesitas ayuda con tu compra?</p>
                    <p class="mb-0">¡Estamos aquí para ayudarte!</p>
                </div>
                
                <div class="card-body p-4">
                    <?php if (session()->has('mensaje')): ?>
                        <div class="alert alert-success">
                            <?= session('mensaje') ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (session()->has('errors')): ?>
                        <div class="alert alert-danger">
                            <ul>
                                <?php foreach (session('errors') as $error): ?>
                                    <li><?= $error ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    
                    <form action="<?= site_url('front/contacto/enviar') ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="form_name" class="form-label">Nombre</label>
                                    <input id="form_name" type="text" name="nombre" 
                                           class="form-control bg-dark text-info border-info" 
                                           required data-error="Nombre es requerido.">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="form_lastname" class="form-label">Apellido</label>
                                    <input id="form_lastname" type="text" name="apellido" 
                                           class="form-control bg-dark text-info border-info" 
                                           required data-error="Apellido es requerido.">
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="form_email" class="form-label">Email</label>
                                    <input id="form_email" type="email" name="email" 
                                           class="form-control bg-dark text-info border-info" 
                                           required data-error="Un Email válido es requerido.">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="form_need" class="form-label">Asunto</label>
                                    <input id="form_need" type="text" name="asunto" 
                                           class="form-control bg-dark text-info border-info" 
                                           required data-error="Asunto requerido.">
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="form_message" class="form-label">Consulta</label>
                                    <textarea id="form_message" name="consulta" 
                                              class="form-control bg-dark text-info border-info" 
                                              rows="4" required 
                                              placeholder="Escriba su consulta aquí..."
                                              data-error="Por favor, escriba su consulta."></textarea>
                                </div>
                            </div>
                            
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-info text-black rounded-pill px-5">
                                    <i class="fas fa-paper-plane me-2"></i>Enviar Consulta
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
