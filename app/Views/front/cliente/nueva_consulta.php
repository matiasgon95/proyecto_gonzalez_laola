<?= $this->extend('front/layout/layouts'); ?>

<?= $this->section('contenedor'); ?>

<!-- Contenedor principal del formulario de consulta -->
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Tarjeta principal con borde y sombra -->
            <div class="card shadow border border-info">
                <!-- Encabezado de la tarjeta con título y descripción -->
                <div class="card-header bg-info text-black text-center py-4">
                    <h1 class="h3 mb-2">Nueva Consulta</h1>
                    <p class="mb-0">¿Tienes preguntas sobre nuestros productos o necesitas ayuda con tu compra?</p>
                    <p class="mb-0">¡Estamos aquí para ayudarte!</p>
                </div>
                
                <div class="card-body p-4">
                    <!-- Mensaje de éxito si existe en la sesión -->
                    <?php if (session()->has('mensaje')): ?>
                        <div class="alert alert-success">
                            <?= session('mensaje') ?>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Mensajes de error si existen en la sesión -->
                    <?php if (session()->has('errors')): ?>
                        <div class="alert alert-danger">
                            <ul>
                                <?php foreach (session('errors') as $error): ?>
                                    <li><?= $error ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Formulario de consulta con protección CSRF -->
                    <form action="<?= site_url('front/cliente/guardar_consulta') ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="row g-3">
                            <!-- Campo para el asunto de la consulta -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="form_need" class="form-label">Asunto</label>
                                    <input id="form_need" type="text" name="asunto" 
                                           class="form-control bg-dark text-info border-info" 
                                           required data-error="Asunto requerido."
                                           value="<?= old('asunto') ?>">
                                </div>
                            </div>
                            
                            <!-- Campo para el mensaje de la consulta -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="form_message" class="form-label">Mensaje</label>
                                    <textarea id="form_message" name="mensaje" 
                                              class="form-control bg-dark text-info border-info" 
                                              rows="4" required 
                                              placeholder="Escriba su consulta aquí..."
                                              data-error="Por favor, escriba su mensaje."><?= old('mensaje') ?></textarea>
                                </div>
                            </div>
                            
                            <!-- Botones de acción: volver y enviar consulta -->
                            <div class="col-12 text-center">
                                <a href="<?= base_url('front/cliente/consultas') ?>" class="btn btn-outline-info rounded-pill px-4 me-2">
                                    <i class="fas fa-arrow-left me-2"></i>Volver
                                </a>
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