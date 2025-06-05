<?php echo $this->extend('front/layout/layouts'); ?>

<?= $this->section('contenedor'); ?>

<div class="container-fluid py-5 bg-dark text-info">
    <div class="container">
        <h1 class="display-4 text-center mb-5 text-info fw-bold">Comercialización</h1>

        <div class="card bg-dark border-info mb-4">
            <div class="card-body text-info">
                <p class="lead">En <strong class="text-info">GL Technology</strong>, trabajamos para que tu experiencia de compra sea rápida, segura y eficiente. A continuación, te detallamos todo lo que necesitás saber sobre nuestros procesos de entrega, envío y formas de pago.</p>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-6">
                <div class="card h-100 bg-dark border-info hover-card">
                    <div class="card-body text-info">
                        <h3 class="card-title text-center mb-4">Tipos de Entregas</h3>
                        <ul class="list-group list-group-flush bg-dark">
                            <li class="list-group-item bg-dark text-info border-info">✓ Retiro en tienda: Sin costo adicional</li>
                            <li class="list-group-item bg-dark text-info border-info">✓ Entrega programada: Coordina día y horario</li>
                            <li class="list-group-item bg-dark text-info border-info">✓ Entrega inmediata: Disponible según stock</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card h-100 bg-dark border-info hover-card">
                    <div class="card-body text-info">
                        <h3 class="card-title text-center mb-4">Formas de Envío</h3>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item bg-dark text-info border-info">✓ Correo y transportes reconocidos</li>
                            <li class="list-group-item bg-dark text-info border-info">✓ Envío propio en zonas cercanas</li>
                            <li class="list-group-item bg-dark text-info border-info">✓ Servicio de envío exprés</li>
                        </ul>
                        <p class="mt-3 fst-italic">El costo varía según destino y modalidad</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card h-100 bg-dark border-info hover-card">
                    <div class="card-body text-info">
                        <h3 class="card-title text-center mb-4">Formas de Pago</h3>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item bg-dark text-info border-info">✓ Efectivo (en tienda)</li>
                            <li class="list-group-item bg-dark text-info border-info">✓ Mercado Pago</li>
                            <li class="list-group-item bg-dark text-info border-info">✓ Tarjetas de crédito/débito</li>
                            <li class="list-group-item bg-dark text-info border-info">✓ Planes Ahora 3, 6, 12</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card h-100 bg-dark border-info hover-card">
                    <div class="card-body text-info">
                        <h3 class="card-title text-center mb-4">Información Adicional</h3>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item bg-dark text-info border-info">✓ Garantía oficial del fabricante</li>
                            <li class="list-group-item bg-dark text-info border-info">✓ Factura A o B</li>
                            <li class="list-group-item bg-dark text-info border-info">✓ Asesoramiento personalizado</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
