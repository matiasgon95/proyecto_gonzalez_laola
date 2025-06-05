<?= $this->extend('front/layout/layouts') ?>
<?= $this->section('contenedor') ?>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2 text-warning">Papelera de Productos Eliminados</h1>
        <a href="<?= base_url('back/productos') ?>" class="btn btn-info text-black rounded-pill px-4">
            <i class="fas fa-arrow-left"></i> Volver a Productos
        </a>
    </div>
    

    <?php if(session()->getFlashdata('exito')): ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('exito') ?>
        </div>
    <?php endif; ?>

    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <div class="card shadow border border-warning">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-warning table-striped align-middle">
                    <thead class="table-dark text-warning">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Categoría</th>
                            <th>Precio</th>
                            <th>Stock</th>
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
                                    <td class="text-nowrap"><?= esc($producto['nombre']) ?></td>
                                    <td>
                                        <div class="descripcion-celda" title="<?= esc($producto['descripcion']) ?>">
                                            <?= esc($producto['descripcion']) ?>
                                        </div>
                                    </td>
                                    <td class="text-nowrap"><?= esc($producto['categoria_descripcion']) ?></td>
                                    <td>$<?= number_format($producto['precio'], 2) ?></td>
                                    <td><?= $producto['stock'] ?></td>
                                    <td class="text-nowrap"><?= date('d/m/Y', strtotime($producto['created_at'])) ?></td>
                                    <td class="text-nowrap"><?= date('d/m/Y', strtotime($producto['updated_at'])) ?></td>
                                    <td>
                                        <?php if (!empty($producto['imagen'])): ?>
                                            <img src="<?= base_url('public/' . $producto['imagen']) ?>" alt="Imagen producto" class="img-thumbnail border-warning" style="max-width: 60px; max-height: 60px; object-fit: cover;">
                                        <?php else: ?>
                                            <span class="text-muted">No hay imagen</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="<?= base_url('back/productos/restaurar/' . $producto['id']) ?>" 
                                               onclick="return confirm('¿Restaurar este producto?')" 
                                               class="btn btn-sm btn-outline-success">
                                                <i class="fas fa-undo"></i>
                                            </a>
                                            <a href="<?= base_url('back/productos/eliminar_definitivo/' . $producto['id']) ?>"
                                                onclick="return confirm('¿Estás seguro de eliminar este producto de forma permanente?')"
                                                class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-times"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="10" class="text-center text-muted">No hay productos eliminados.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
