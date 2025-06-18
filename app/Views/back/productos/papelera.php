<?= $this->extend('front/layout/layouts') ?> <!-- Extiende la plantilla principal -->
<?= $this->section('contenedor') ?> <!-- Inicia la sección de contenido -->

<!-- Contenedor principal -->
<div class="container-fluid py-4">
    <!-- Encabezado con título y botón de retorno -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
        <h1 class="h2 text-warning mb-3 mb-md-0">Papelera de Productos Eliminados</h1>
        <a href="<?= base_url('back/productos') ?>" class="btn btn-info text-black rounded-pill px-4">
            <i class="fas fa-arrow-left"></i> Volver a Productos
        </a>
    </div>
    
    <!-- Mensajes de alerta para operaciones exitosas -->
    <?php if(session()->getFlashdata('exito')): ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('exito') ?>
        </div>
    <?php endif; ?>

    <!-- Mensajes de alerta para errores -->
    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <!-- Tarjeta principal con la tabla de productos -->
    <div class="card shadow border border-warning">
        <div class="card-body p-0 p-sm-2"> <!-- Reducir aún más el padding en móviles -->
            <!-- Mensaje de desplazamiento horizontal - solo visible en móviles -->
            <div class="d-block d-md-none alert alert-warning py-2 mb-2 text-center small">
                <i class="fas fa-arrows-left-right me-1"></i> Desliza horizontalmente para ver toda la tabla
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-dark table-striped align-middle mb-0 admin-table productos-papelera-table">
                    <!-- Encabezado de la tabla -->
                    <thead class="table-warning text-black">
                        <tr>
                            <th class="nombre-column text-center">Nombre</th>
                            <th class="descripcion-column d-none d-md-table-cell text-center">Descripción</th>
                            <th class="categoria-column text-center">Categoría</th>
                            <th class="precio-column text-center">Precio</th>
                            <th class="precio-column d-none d-sm-table-cell text-center">P.vta</th>
                            <th class="stock-column text-center">Stock</th>
                            <th class="stock-column d-none d-md-table-cell text-center text-nowrap">Mínimo</th>
                            <th class="fecha-column d-none d-lg-table-cell text-center">Creado</th>
                            <th class="fecha-column d-none d-lg-table-cell text-center">Modificado</th>
                            <th class="imagen-column text-center">Imagen</th>
                            <th class="actions-column text-center">Acciones</th>
                        </tr>
                    </thead>
                    <!-- Cuerpo de la tabla con los productos eliminados -->
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
                                    <td>$<?= number_format($producto['precio'], 2, ',', '.') ?></td>
                                    <td class="d-none d-sm-table-cell">$<?= number_format($producto['precio_vta'], 2, ',', '.') ?></td>
                                    <!-- Celda de stock con indicador visual para stock bajo -->
                                    <td class="<?= ($producto['stock'] < $producto['stock_min']) ? 'text-danger fw-bold' : '' ?>">
                                        <?= $producto['stock'] ?>
                                        <?php if ($producto['stock'] < $producto['stock_min']) : ?>
                                            <i class="fas fa-exclamation-triangle ms-1 text-warning" title="Stock bajo"></i>
                                        <?php endif; ?>
                                    </td>
                                    <td class="d-none d-md-table-cell"><?= $producto['stock_min'] ?></td>
                                    <!-- Fechas de creación con formato personalizado -->
                                    <td class="fecha-celda d-none d-lg-table-cell">
                                        <div><?= date('d/m/y', strtotime($producto['created_at'])) ?></div>
                                        <div class="hora-celda"><?= date('H:i', strtotime($producto['created_at'])) ?></div>
                                    </td>
                                    <!-- Fechas de modificación con formato personalizado -->
                                    <td class="fecha-celda d-none d-lg-table-cell">
                                        <div><?= date('d/m/y', strtotime($producto['updated_at'])) ?></div>
                                        <div class="hora-celda"><?= date('H:i', strtotime($producto['updated_at'])) ?></div>
                                    </td>
                                    <!-- Miniatura de imagen con opción para ampliar -->
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
                                    <!-- Botones de acción: restaurar y eliminar definitivamente -->
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
                            <!-- Mensaje cuando no hay productos eliminados -->
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

<?= $this->endSection() ?> <!-- Finaliza la sección de contenido -->