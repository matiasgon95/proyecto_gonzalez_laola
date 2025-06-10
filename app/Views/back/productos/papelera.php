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
        <div class="card-body p-0 p-sm-2"> <!-- Reducir aún más el padding en móviles -->
            <div class="table-responsive">
                <table class="table table-hover table-dark table-striped align-middle mb-0 admin-table productos-papelera-table">
                    <thead class="table-warning text-black">
                        <tr>
                            <th class="nombre-column">Nombre</th>
                            <th class="descripcion-column d-none d-md-table-cell">Descripción</th>
                            <th class="categoria-column">Categoría</th>
                            <th class="precio-column">Precio</th>
                            <th class="precio-column d-none d-sm-table-cell">P.vta</th>
                            <th class="stock-column">Stock</th>
                            <th class="stock-column d-none d-md-table-cell">Mínimo</th>
                            <th class="fecha-column d-none d-lg-table-cell">Creado</th>
                            <th class="fecha-column d-none d-lg-table-cell">Modificado</th>
                            <th class="imagen-column">Imagen</th>
                            <th class="actions-column">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($productos) && is_array($productos)) : ?>
                            <?php foreach ($productos as $producto) : ?>
                                <tr>
                                    <td class="text-nowrap nombre-celda"><?= esc($producto['nombre']) ?></td>
                                    <td class="d-none d-md-table-cell">
                                        <div class="descripcion-celda" title="<?= esc($producto['descripcion']) ?>">
                                            <?= esc($producto['descripcion']) ?>
                                        </div>
                                    </td>
                                    <td class="text-nowrap categoria-celda"><?= esc($producto['categoria_descripcion']) ?></td>
                                    <td>$<?= number_format($producto['precio'], 2) ?></td>
                                    <td class="d-none d-sm-table-cell">$<?= number_format($producto['precio_vta'], 2) ?></td>
                                    <td class="<?= ($producto['stock'] < $producto['stock_min']) ? 'text-danger fw-bold' : '' ?>">
                                        <?= $producto['stock'] ?>
                                        <?php if ($producto['stock'] < $producto['stock_min']) : ?>
                                            <i class="fas fa-exclamation-triangle ms-1 text-warning" title="Stock bajo"></i>
                                        <?php endif; ?>
                                    </td>
                                    <td class="d-none d-md-table-cell"><?= $producto['stock_min'] ?></td>
                                    <td class="fecha-celda d-none d-lg-table-cell">
                                        <div><?= date('d/m/y', strtotime($producto['created_at'])) ?></div>
                                        <div class="hora-celda"><?= date('H:i', strtotime($producto['created_at'])) ?></div>
                                    </td>
                                    <td class="fecha-celda d-none d-lg-table-cell">
                                        <div><?= date('d/m/y', strtotime($producto['updated_at'])) ?></div>
                                        <div class="hora-celda"><?= date('H:i', strtotime($producto['updated_at'])) ?></div>
                                    </td>
                                    <td class="text-center">
                                        <?php if (!empty($producto['imagen'])): ?>
                                            <img src="<?= base_url('public/' . $producto['imagen']) ?>" 
                                                 alt="Imagen producto" 
                                                 class="img-thumbnail border-warning" 
                                                 style="width: 40px; height: 40px; object-fit: cover;"
                                                 onclick="mostrarImagenModal('<?= base_url('public/' . $producto['imagen']) ?>', '<?= esc($producto['nombre']) ?>')">
                                        <?php else: ?>
                                            <span class="text-muted">No</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="<?= base_url('back/productos/restaurar/' . $producto['id']) ?>" 
                                               onclick="return confirm('¿Restaurar este producto?')" 
                                               class="btn btn-sm btn-outline-success" title="Restaurar">
                                                <i class="fas fa-undo"></i>
                                            </a>
                                            <a href="<?= base_url('back/productos/eliminar_definitivo/' . $producto['id']) ?>"
                                                onclick="return confirm('¿Estás seguro de eliminar este producto de forma permanente?')"
                                                class="btn btn-sm btn-outline-danger" title="Eliminar definitivamente">
                                                <i class="fas fa-times"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="11" class="text-center text-muted">No hay productos eliminados.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal para mostrar imagen ampliada -->
<div class="modal fade" id="imagenModal" tabindex="-1" aria-labelledby="imagenModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-dark">
            <div class="modal-header border-warning">
                <h5 class="modal-title text-warning" id="imagenModalLabel">Imagen del Producto</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="modal-img-container">
                    <img id="imagenModalSrc" src="" alt="Imagen ampliada" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function mostrarImagenModal(imagenSrc, nombreProducto) {
        document.getElementById('imagenModalSrc').src = imagenSrc;
        document.getElementById('imagenModalLabel').textContent = 'Imagen: ' + nombreProducto;
        var modal = new bootstrap.Modal(document.getElementById('imagenModal'));
        modal.show();
    }
</script>

<?= $this->endSection() ?>
