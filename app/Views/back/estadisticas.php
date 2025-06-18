<!-- Al principio del archivo, después de las etiquetas de extensión -->
<?= $this->extend('front/layout/layouts') ?>
<?= $this->section('contenedor') ?>

<!-- Agregar esta línea para incluir el CSS -->
<link rel="stylesheet" href="<?= base_url('assets/css/estadisticas.css') ?>">

<!-- Contenedor principal de la página de estadísticas -->
<div class="container-fluid py-4">
    <!-- Encabezado con título y botón de regreso -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
        <h1 class="h2 text-info mb-3 mb-md-0">Estadísticas del Sistema</h1>
        <a href="<?= base_url('back/dashboard') ?>" class="btn btn-outline-info rounded-pill px-4 align-self-start align-self-md-auto">
            <i class="fas fa-arrow-left"></i> Volver al Panel
        </a>
    </div>
    
    <!-- Tarjetas de resumen con indicadores clave -->
    <div class="row g-4 mb-5">
        <!-- Tarjeta de usuarios -->
        <div class="col-md-6 col-lg-3">
            <div class="card bg-dark border-info h-100">
                <div class="card-body text-center">
                    <i class="fas fa-users fa-3x mb-3 text-info"></i>
                    <h5 class="card-title text-info">Total Usuarios</h5>
                    <p class="display-4 text-info"><?= $total_usuarios ?></p>
                    <p class="text-info-emphasis">Clientes: <?= $total_clientes ?></p>
                </div>
            </div>
        </div>
        
        <!-- Tarjeta de productos -->
        <div class="col-md-6 col-lg-3">
            <div class="card bg-dark border-info h-100">
                <div class="card-body text-center">
                    <i class="fas fa-box fa-3x mb-3 text-info"></i>
                    <h5 class="card-title text-info">Total Productos</h5>
                    <p class="display-4 text-info"><?= $total_productos ?></p>
                    <p class="text-info-emphasis">Categorías: <?= $total_categorias ?></p>
                </div>
            </div>
        </div>
        
        <!-- Tarjeta de pedidos -->
        <div class="col-md-6 col-lg-3">
            <div class="card bg-dark border-info h-100">
                <div class="card-body text-center">
                    <i class="fas fa-shopping-cart fa-3x mb-3 text-info"></i>
                    <h5 class="card-title text-info">Total Pedidos</h5>
                    <p class="display-4 text-info"><?= $total_pedidos ?></p>
                    <p class="text-info-emphasis">Este mes: <?= $pedidos_mes ?></p>
                </div>
            </div>
        </div>
        
        <!-- Tarjeta de ventas -->
        <div class="col-md-6 col-lg-3">
            <div class="card bg-dark border-info h-100">
                <div class="card-body text-center">
                    <i class="fas fa-dollar-sign fa-3x mb-3 text-info"></i>
                    <h5 class="card-title text-info">Ventas Totales</h5>
                    <p class="display-4 text-info">$<?= number_format($total_ventas, 2, ',', '.') ?></p>
                    <p class="text-info-emphasis">Este mes: $<?= number_format($ventas_mes, 2, ',', '.') ?></p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Gráficos y estadísticas detalladas -->
    <div class="row g-4">
        <!-- Gráfico de ventas por mes -->
        <div class="col-lg-8">
            <div class="card bg-dark border-info">
                <div class="card-header bg-info text-dark">
                    <h5 class="mb-0">Ventas por Mes</h5>
                </div>
                <div class="card-body">
                    <canvas id="ventasPorMes" 
                           data-meses='<?= json_encode($meses) ?>' 
                           data-ventas='<?= json_encode($datos_ventas) ?>'
                           height="300"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Productos más vendidos -->
        <div class="col-lg-4">
            <div class="card bg-dark border-info h-100">
                <div class="card-header bg-info text-dark">
                    <h5 class="mb-0">Productos Más Vendidos</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush bg-transparent">
                        <?php foreach ($productos_top as $producto): ?>
                        <li class="list-group-item bg-dark text-info d-flex justify-content-between align-items-center">
                            <span><?= $producto['nombre'] ?></span>
                            <span class="badge bg-info text-dark rounded-pill"><?= $producto['cantidad'] ?> unidades</span>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
        
        <!-- Gráfico de productos por categoría -->
        <div class="col-lg-6">
            <div class="card bg-dark border-info">
                <div class="card-header bg-info text-dark">
                    <h5 class="mb-0">Productos por Categoría</h5>
                </div>
                <div class="card-body">
                    <canvas id="productosPorCategoria"
                           data-categorias='<?= json_encode($categorias) ?>'
                           data-productos='<?= json_encode($productos_por_categoria) ?>'
                           height="300"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Stock bajo mínimo -->
        <div class="col-lg-6">
            <div class="card bg-dark border-info">
                <div class="card-header bg-info text-dark">
                    <h5 class="mb-0">Productos con Stock Bajo</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-dark table-hover">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th class="text-center">Stock Actual</th>
                                    <th class="text-center">Stock Mínimo</th>
                                    <th class="text-center">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($productos_stock_bajo as $producto): ?>
                                <tr>
                                    <td><?= $producto['nombre'] ?></td>
                                    <td class="text-center text-<?= $producto['stock'] <= $producto['stock_min'] ? 'danger' : 'warning' ?>">
                                        <?= $producto['stock'] ?>
                                    </td>
                                    <td class="text-center"><?= $producto['stock_min'] ?></td>
                                    <td class="text-center">
                                        <a href="<?= base_url('back/productos/editar/' . $producto['id']) ?>" class="btn btn-sm btn-info">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Al final del archivo, antes de cerrar la sección -->
<!-- Incluir Chart.js desde CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Incluir el archivo JavaScript externo -->
<script src="<?= base_url('assets/js/estadisticas.js') ?>"></script>

<?= $this->endSection() ?>