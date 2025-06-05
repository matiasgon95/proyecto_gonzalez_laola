<?= $this->extend('front/layout/layouts') ?>
<?= $this->section('contenedor') ?>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2 text-info">Listado de Productos</h1>
        <div>
            <a href="<?= base_url('back/productos/crear') ?>" class="btn btn-info text-black rounded-pill px-4 me-2">
                <i class="fas fa-plus"></i> Nuevo Producto
            </a>
            <a href="<?= base_url('back/productos/papelera') ?>" class="btn btn-warning text-black rounded-pill px-4">
                <i class="fas fa-trash-alt"></i> Papelera
            </a>
        </div>
    </div>


    <div class="card shadow border border-info">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-dark table-striped align-middle">
                    <thead class="table-info text-black">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Categoría</th>
                            <th>Precio</th>
                            <th>Precio Venta</th>
                            <th>Stock</th>
                            <th>Stock Mínimo</th>
                            <th>Creado</th>
                            <th>Modificado</th>
                            <th>Imagen</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($productos) && is_array($productos)) : ?>
                            <?php foreach ($productos as $producto) : ?>
                                <tr>
                                    <td><?= $producto['id'] ?></td>
                                    <td><?= esc($producto['nombre']) ?></td>
                                    <td>
                                        <div class="descripcion-celda" title="<?= esc($producto['descripcion']) ?>">
                                            <?= esc($producto['descripcion']) ?>
                                        </div>
                                    </td>
                                    <td><?= esc($producto['categoria_descripcion']) ?></td>
                                    <td>$<?= number_format($producto['precio'], 2) ?></td>
                                    <td>$<?= number_format($producto['precio_vta'], 2) ?></td>
                                    <td class="<?= ($producto['stock'] < $producto['stock_min']) ? 'text-danger fw-bold' : '' ?>">
                                        <?= $producto['stock'] ?>
                                        <?php if ($producto['stock'] < $producto['stock_min']) : ?>
                                            <i class="fas fa-exclamation-triangle ms-1 text-warning" title="Stock bajo"></i>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= $producto['stock_min'] ?></td>
                                    <td><?= date('d/m/Y H:i', strtotime($producto['created_at'])) ?></td>
                                    <td><?= date('d/m/Y H:i', strtotime($producto['updated_at'])) ?></td>
                                    <td>
                                        <?php if (!empty($producto['imagen'])): ?>
                                            <img src="<?= base_url('public/' . $producto['imagen']) ?>" alt="Imagen producto" class="img-thumbnail border-info" style="max-width: 80px;">
                                        <?php else: ?>
                                            <span class="text-muted">No hay imagen</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="<?= base_url('back/productos/editar/' . $producto['id']) ?>" class="btn btn-sm btn-outline-info">
                                                <i class="fas fa-edit"></i> Editar
                                            </a>
                                            <a href="<?= base_url('back/productos/eliminar/' . $producto['id']) ?>" 
                                            onclick="return confirm('¿Estás seguro de eliminar este producto?')" 
                                            class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-trash"></i> Eliminar
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="11" class="text-center text-muted">No hay productos disponibles.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
