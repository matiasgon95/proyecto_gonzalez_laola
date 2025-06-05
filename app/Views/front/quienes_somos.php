<?php echo $this->extend('front/layout/layouts'); ?>

<?= $this->section('contenedor'); ?>

<div class="container-fluid py-5 bg-dark text-info">
    <div class="container">
        <h1 class="display-4 text-center mb-5 text-info fw-bold">¿Quiénes somos?</h1>

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card bg-dark border-info hover-card mb-4">
                    <div class="card-body text-info">
                        <p class="lead mb-4">En <strong class="text-info">GL Technology</strong> somos un equipo apasionado por la tecnología y el alto rendimiento. Nos dedicamos a ofrecer hardware de calidad para todos los niveles: desde entusiastas del gaming hasta profesionales y empresas.</p>
                        
                        <p class="lead mb-4">Creemos que la tecnología no es solo una herramienta, sino una forma de potenciar ideas, proyectos y experiencias. Por eso, trabajamos con las mejores marcas del mercado y brindamos un asesoramiento personalizado, para ayudarte a encontrar exactamente lo que necesitás.</p>

                        <div class="card bg-dark border-info mb-4">
                            <div class="card-body text-center">
                                <p class="lead mb-0">Ofrecemos desde PCs armadas, componentes como placas de video, procesadores, memorias, fuentes y accesorios.</p>
                            </div>
                        </div>

                        <p class="lead mb-4">Nuestro compromiso es brindarte rendimiento, confiabilidad y servicio, para que tu inversión en tecnología sea siempre una decisión acertada.</p>

                        <div class="text-center mt-5">
                            <h2 class="display-6 fw-bold text-info">GL Technology - Tu mundo, potenciado.</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
