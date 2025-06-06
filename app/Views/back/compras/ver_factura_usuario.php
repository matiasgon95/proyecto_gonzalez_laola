<div class="container my-5">
    <div class="card bg-dark text-info border-info">
        <div class="card-header bg-info text-dark">
            <h3 class="mb-0">Historial de Compras</h3>
        </div>
        <div class="card-body">
            <?php if (empty($ventas)): ?>
                <div class="alert alert-info">
                    No tienes compras registradas todavía.
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-dark table-hover">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Total</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($ventas as $venta): ?>
                            <tr>
                                <td><?= date('d/m/Y H:i', strtotime($venta['created_at'])) ?></td>
                                <td>$<?= number_format($venta['total_venta'], 2) ?></td>
                                <td>
                                    <a href="<?= base_url('vista_compras/' . $venta['id']) ?>" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i> Ver detalle
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
            <div class="mt-4 text-center">
                <a href="<?= base_url('productos') ?>" class="btn btn-info">Volver a la tienda</a>
            </div>
        </div>
    </div>
</div>