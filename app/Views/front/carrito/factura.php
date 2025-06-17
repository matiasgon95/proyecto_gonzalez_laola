<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Metadatos básicos y título dinámico -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titulo ?></title>
    <!-- Hojas de estilo: Bootstrap, FontAwesome y estilos personalizados -->
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/fontawesome/css/all.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/paginas.css') ?>">
</head>
<body>
    <!-- Contenedor principal de la factura -->
    <div class="factura">
        <!-- Encabezado de la factura con información básica y logo -->
        <div class="factura-header">
            <div>
                <h1>FACTURA</h1>
                <p>Factura #: <?= $numero_factura ?></p>
                <p>Fecha: <?= date('d/m/Y H:i', strtotime($fecha)) ?></p>
            </div>
            <div>
                <img src="<?= base_url('assets/img/logo.png') ?>" alt="Logo">
                <p>Gonzalez Laola Informática</p>
                <p>CUIT: 30-12345678-9</p>
                <p>Dirección: Av. Siempreviva 742</p>
                <p>Tel: (379) 4567890</p>
            </div>
        </div>
        
        <!-- Información del cliente y detalles de la factura -->
        <div class="factura-info">
            <h4>Datos del Cliente:</h4>
            <div class="factura-info-row">
                <div>
                    <!-- Datos del cliente obtenidos de la sesión -->
                    <p><strong>Cliente:</strong> <?= session()->get('usuario_nombre') . ' ' . session()->get('usuario_apellido') ?></p>
                    <p><strong>Email:</strong> <?= session()->get('usuario_email') ?></p>
                </div>
                <div>
                    <!-- Detalles de la factura -->
                    <p><strong>Factura:</strong> <?= $numero_factura ?></p>
                    <p><strong>Fecha de emisión:</strong> <?= date('d/m/Y', strtotime($fecha)) ?></p>
                </div>
            </div>
        </div>
        
        <!-- Tabla de productos comprados -->
        <table class="factura-table">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                // Inicialización del total
                $total = 0;
                // Iteración sobre cada producto en la venta
                foreach ($venta as $item): 
                    // Cálculo del precio unitario y acumulación del total
                    $precio_unitario = $item['precio'] / $item['cantidad'];
                    $total += $item['precio'];
                ?>
                <tr>
                    <!-- Nombre del producto con escape para seguridad -->
                    <td><?= esc($item['nombre']) ?></td>
                    <!-- Cantidad, precio unitario y subtotal formateados -->
                    <td><?= $item['cantidad'] ?></td>
                    <td>$<?= number_format($precio_unitario, 2, ',', '.') ?></td>
                    <td>$<?= number_format($item['precio'], 2, ',', '.') ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <!-- Fila de total general -->
                    <td colspan="3" style="text-align: right;"><strong>Total:</strong></td>
                    <td><strong>$<?= number_format($total, 2, ',', '.') ?></strong></td>
                </tr>
            </tfoot>
        </table>      
        <!-- Botones de acción (no se muestran al imprimir) -->
        <div class="text-center no-print">
            <!-- Botón para imprimir la factura -->
            <button class="btn-print" onclick="window.print()">
                <i class="fas fa-print"></i> Imprimir Factura
            </button>
            <!-- Enlace para volver a la página de pedidos -->
            <a href="<?= base_url('front/cliente/pedidos') ?>" class="btn-print" style="text-decoration: none; display: inline-block; margin-left: 10px;">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>
</body>
</html>