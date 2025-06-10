<?= $this->extend('front/layout/layouts') ?>
<?= $this->section('contenedor') ?>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2 text-info">Listado de Productos</h1>
        <div>
            <button type="button" class="btn btn-success text-black rounded-pill px-4 me-2" data-bs-toggle="modal" data-bs-target="#modalCrearCategoria">
                <i class="fas fa-tags"></i> Nueva Categoría
            </button>
            <a href="<?= base_url('back/productos/crear') ?>" class="btn btn-info text-black rounded-pill px-4 me-2">
                <i class="fas fa-plus"></i> Nuevo Producto
            </a>
            <a href="<?= base_url('back/productos/papelera') ?>" class="btn btn-warning text-black rounded-pill px-4">
                <i class="fas fa-trash-alt"></i> Papelera
            </a>
        </div>
    </div>

    <!-- Modal para crear categoría -->
    <div class="modal fade" id="modalCrearCategoria" tabindex="-1" aria-labelledby="modalCrearCategoriaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-dark text-info border border-info">
                <div class="modal-header bg-info text-black">
                    <h5 class="modal-title" id="modalCrearCategoriaLabel">Crear Nueva Categoría</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Eliminar estas líneas comentadas -->
                    <!-- <form id="formCrearCategoria" action="<?= base_url('back/productos/guardar-categoria') ?>" method="post"> -->
                    
                    <!-- Cambiar esto: -->
                    <form id="formCrearCategoria" action="<?= base_url('back/productos/guardar_categoria') ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Nombre de la categoría</label>
                            <input type="text" class="form-control bg-dark text-info border-info" id="descripcion" name="descripcion" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-info" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" form="formCrearCategoria" class="btn btn-info text-black">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Mensaje de éxito para categoría creada -->
    <?php if (session()->getFlashdata('mensaje_categoria')) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('mensaje_categoria') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card shadow border border-info">
        <div class="card-body p-0 p-sm-2">
            <div class="table-responsive">
                <table class="table table-hover table-dark table-striped align-middle mb-0 admin-table productos-table">
                    <thead class="table-info text-black">
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
                                                 class="img-thumbnail border-info" 
                                                 style="width: 40px; height: 40px; object-fit: cover;"
                                                 onclick="mostrarImagenModal('<?= base_url('public/' . $producto['imagen']) ?>', '<?= esc($producto['nombre']) ?>')">
                                        <?php else: ?>
                                            <span class="text-muted">No</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
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
