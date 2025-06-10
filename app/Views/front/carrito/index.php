<?= $this->extend('front/layout/layouts'); ?>

<?= $this->section('contenedor'); ?>
<div class="container py-4" id="carrito">
    <div class="cart shadow-sm p-3 p-md-4 bg-dark text-light rounded">
        <div class="heading mb-4">
            <h2 class="text-info text-center">Productos en tu Carrito</h2>
        </div>
        
        <!-- Mostrar mensaje Flash si existe -->
        <?php if (session()->getFlashdata('mensaje')): ?>
            <div class="alert alert-info alert-dismissible fade show mt-3 mx-3 fw-bold" role="alert">
                <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between">
                    <div>
                        <i class="fas fa-info-circle me-2"></i><?= session()->getFlashdata('mensaje') ?>
                    </div>
                    <a href="<?= base_url('carrito') ?>" class="btn btn-info btn-sm mt-2 mt-sm-0"><i class="fas fa-shopping-cart me-1"></i>Ver carrito</a>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        <?php endif; ?>
        
        <div>
            <div class="text-center">
                <?php if (empty($cart)): ?>
                    <div class="alert alert-info p-4">
                        <p class="mb-3">Tu carrito está vacío. Para agregar productos al carrito, hacé clic en:</p>
                        <a class="btn btn-info text-dark mt-2" href="<?= base_url('productos') ?>"><i class="fas fa-shopping-cart me-2"></i> Ir al catálogo</a>
                    </div>
                <?php else: ?>
                    <form action="<?= base_url('carrito_actualiza') ?>" method="post">
                        <div class="container-fluid px-0 my-3">
                            <div class="table-responsive">
                                <table class="table table-hover table-dark table-striped border border-secondary table-cart">
                                    <thead class="table-info text-dark">
                                        <tr>
                                            <th>IMAGEN</th>
                                            <th>PRODUCTO</th>
                                            <th>PRECIO</th>
                                            <th>CANTIDAD</th>
                                            <th>TOTAL</th>
                                            <th>ACCIÓN</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $gran_total = 0; ?>
                                        <?php foreach ($cart as $item): ?>
                                            <?php 
                                                $gran_total += $item['price'] * $item['qty'];
                                            ?>
                                            <!-- Inputs ocultos, el usuario no ve esos datos pero el formulario los envía -->
                                            <input type="hidden" name="cart[<?= esc($item['rowid']) ?>][id]" value="<?= esc($item['id']) ?>">
                                            <input type="hidden" name="cart[<?= esc($item['rowid']) ?>][rowid]" value="<?= esc($item['rowid']) ?>">
                                            <input type="hidden" name="cart[<?= esc($item['rowid']) ?>][name]" value="<?= esc($item['name']) ?>">
                                            <input type="hidden" name="cart[<?= esc($item['rowid']) ?>][price]" value="<?= esc($item['price']) ?>">
                                            <input type="hidden" name="cart[<?= esc($item['rowid']) ?>][qty]" value="<?= esc($item['qty']) ?>">
                                            <input type="hidden" name="cart[<?= esc($item['rowid']) ?>][imagen]" value="<?= esc($item['imagen']) ?>">
                                            <tr>
                                                <td class="align-middle">
                                                    <img src="<?= base_url('public/' . $item['imagen']) ?>" class="img-thumbnail" width="80" height="80" alt="<?= esc($item['name']) ?>"></td>
                                                <td class="align-middle"><?= esc($item['name']) ?></td>
                                                <td class="align-middle">$ <?= number_format($item['price'], 2, ',', '.') ?></td>
                                                <td class="align-middle">
                                                    <div class="d-flex align-items-center justify-content-center">
                                                        <a class="btn btn-sm btn-outline-info me-2" href="<?= base_url('carrito_resta/' . $item['rowid']) ?>"><i class="fas fa-minus"></i></a>
                                                        <span class="mx-2"><?= number_format($item['qty'], 0, ',', '.') ?></span>
                                                        <a class="btn btn-sm btn-info ms-2" href="<?= base_url('carrito_suma/' . $item['rowid']) ?>"><i class="fas fa-plus"></i></a>
                                                    </div>
                                                </td>
                                                <td class="align-middle">$ <?= number_format($item['subtotal'], 2, ',', '.') ?></td>
                                                <td class="align-middle">
                                                    <a class="btn btn-sm btn-danger" href="<?= base_url('carrito_elimina/' . $item['rowid']) ?>"><i class="fas fa-trash"></i></a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot class="table-dark">
                                        <tr>
                                            <td colspan="4" class="text-end fw-bold">Total de la compra:</td>
                                            <td class="fw-bold text-info">$ <?= number_format($gran_total, 2, ',', '.') ?></td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            
                            <!-- Botones separados de la tabla -->
                            <div class="mt-4 mb-2 d-flex flex-column flex-sm-row justify-content-center gap-3">
                                <a href="<?= base_url('productos') ?>" class="btn btn-outline-info">
                                    <i class="fas fa-shopping-basket me-2"></i>Seguir comprando
                                </a>
                                <a href="<?= base_url('carrito_vaciar') ?>" onclick="return confirm('¿Estás seguro de que deseas vaciar el carrito?')" class="btn btn-outline-light">
                                    <i class="fas fa-trash me-2"></i>Vaciar Carrito
                                </a>
                                <a href="<?= base_url('carrito_comprar') ?>" class="btn btn-info text-dark">
                                    <i class="fas fa-shopping-cart me-2"></i>Finalizar Compra
                                </a>
                            </div>
                        </div>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('js'); ?>
<script>
    function confirmarVaciar() {
        if (confirm('¿Estás seguro de que deseas vaciar el carrito?')) {
            window.location.href = '<?= base_url('carrito_vaciar') ?>';
        }
    }
</script>
<?= $this->endSection(); ?>