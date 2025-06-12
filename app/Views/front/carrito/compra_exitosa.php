<?= $this->extend('front/layout/layouts'); ?>

<?= $this->section('contenedor'); ?>
<div class="container py-5" id="compra-exitosa">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="shadow-sm p-4 p-md-5 bg-dark text-light rounded">
                <div class="text-center mb-4">
                    <i class="fas fa-check-circle text-success fa-5x mb-3"></i>
                    <h2 class="text-info">¡Compra Realizada con Éxito!</h2>
                    <p class="lead">Gracias por tu compra. Tu pedido ha sido procesado correctamente.</p>
                    <div class="alert alert-info mt-3">
                        <p class="mb-0">Te hemos enviado un correo electrónico con los detalles de tu compra.</p>
                    </div>
                    
                    <?php if(session()->has('ultima_venta_id')): ?>
                    <div class="mt-3">
                        <a href="<?= base_url('carrito/generar_factura/' . session()->get('ultima_venta_id')) ?>" class="btn btn-success" target="_blank">
                            <i class="fas fa-file-invoice me-2"></i>Generar Factura
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
                
                <div class="row mt-5">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <div class="card bg-dark border-info h-100">
                            <div class="card-body text-center d-flex flex-column justify-content-between">
                                <div>
                                    <i class="fas fa-list-alt fa-3x text-info mb-3"></i>
                                    <h4>Ver Mis Pedidos</h4>
                                    <p>Consulta el estado y los detalles de todos tus pedidos realizados.</p>
                                </div>
                                <a href="<?= base_url('front/cliente/pedidos') ?>" class="btn btn-info text-dark mt-3">
                                    <i class="fas fa-eye me-2"></i>Ver Mis Pedidos
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card bg-dark border-info h-100">
                            <div class="card-body text-center d-flex flex-column justify-content-between">
                                <div>
                                    <i class="fas fa-shopping-cart fa-3x text-info mb-3"></i>
                                    <h4>Realizar Otra Compra</h4>
                                    <p>Continúa explorando nuestro catálogo de productos.</p>
                                </div>
                                <a href="<?= base_url('productos') ?>" class="btn btn-info text-dark mt-3">
                                    <i class="fas fa-shopping-basket me-2"></i>Seguir Comprando
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>