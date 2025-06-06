<?= $this->extend('front/layout/layouts') ?>
<?= $this->section('contenedor') ?>

<div class="container-fluid py-4">
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
        <div class="card-body p-0 p-sm-2"> <!-- Reducir aún más el padding en móviles -->
            <div class="table-responsive">
                <table class="table table-hover table-dark table-striped align-middle mb-0">
                    <thead class="table-info text-black">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Categoría</th>
                            <th>Precio</th>
                            <th>P.Vta</th>
                            <th>Stock</th>
                            <th>Mín</th>
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
                                    <td>$<?= number_format($producto['precio_vta'], 2) ?></td>
                                    <td class="<?= ($producto['stock'] < $producto['stock_min']) ? 'text-danger fw-bold' : '' ?>">
                                        <?= $producto['stock'] ?>
                                        <?php if ($producto['stock'] < $producto['stock_min']) : ?>
                                            <i class="fas fa-exclamation-triangle ms-1 text-warning" title="Stock bajo"></i>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= $producto['stock_min'] ?></td>
                                    <td class="fecha-celda">
                                        <div><?= date('d/m/y', strtotime($producto['created_at'])) ?></div>
                                        <div class="hora-celda"><?= date('H:i', strtotime($producto['created_at'])) ?></div>
                                    </td>
                                    <td class="fecha-celda">
                                        <div><?= date('d/m/y', strtotime($producto['updated_at'])) ?></div>
                                        <div class="hora-celda"><?= date('H:i', strtotime($producto['updated_at'])) ?></div>
                                    </td>
                                    <td>
                                        <?php if (!empty($producto['imagen'])): ?>
                                            <img src="<?= base_url('public/' . $producto['imagen']) ?>" 
                                                 alt="Imagen producto" 
                                                 class="img-thumbnail border-info" 
                                                 style="max-width: 60px; max-height: 60px; object-fit: cover;"
                                                 onclick="mostrarImagenModal('<?= base_url('public/' . $producto['imagen']) ?>', '<?= esc($producto['nombre']) ?>')">
                                        <?php else: ?>
                                            <span class="text-muted">No hay imagen</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="<?= base_url('back/productos/editar/' . $producto['id']) ?>" class="btn btn-sm btn-outline-info" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="<?= base_url('back/productos/eliminar/' . $producto['id']) ?>" 
                                            onclick="return confirm('¿Estás seguro de eliminar este producto?')" 
                                            class="btn btn-sm btn-outline-danger" title="Eliminar">
                                                <i class="fas fa-trash"></i>
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

<!-- Modal para mostrar imagen ampliada -->
<div class="modal fade" id="imagenModal" tabindex="-1" aria-labelledby="imagenModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-dark">
            <div class="modal-header border-info">
                <h5 class="modal-title text-info" id="imagenModalLabel">Imagen del Producto</h5>
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
