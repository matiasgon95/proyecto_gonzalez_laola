<div class="container my-5">
    <div class="card bg-dark text-info border-info">
        <div class="card-header bg-info text-dark">
            <h3 class="mb-0">Detalle de Compra</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-dark table-hover">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Imagen</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $total = 0;
                        foreach ($venta as $item): 
                            $total += $item['precio'];
                        ?>
                        <tr>
                            <td><?= esc($item['nombre']) ?></td>
                            <td>
                                <img src="<?= base_url('assets/uploads/' . $item['imagen']) ?>" 
                                     alt="<?= esc($item['nombre']) ?>" 
                                     width="50" height="50">
                            </td>
                            <td><?= $item['cantidad'] ?></td>
                            <td>$<?= number_format($item['precio'] / $item['cantidad'], 2) ?></td>
                            <td>$<?= number_format($item['precio'], 2) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="4" class="text-end">Total:</th>
                            <th>$<?= number_format($total, 2) ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="mt-4 text-center">
                <a href="<?= base_url('productos') ?>" class="btn btn-info">Seguir comprando</a>
                <a href="<?= base_url('mis_compras/' . session('id_usuario')) ?>" class="btn btn-outline-info">Ver todas mis compras</a>
            </div>
        </div>
    </div>
</div>