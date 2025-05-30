<?= $this->extend('front/layout/layouts') ?>
<?= $this->section('contenedor') ?>

<h1>Listado de Productos</h1>

<a href="<?= base_url('back/productos/crear') ?>" class="btn btn-primary">Nuevo Producto</a>

<table border="1" cellpadding="10" cellspacing="0" style="margin-top:20px; width:100%;">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Categoría</th>
            <th>Precio</th>
            <th>Stock</th>
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
                    <td><?= esc($producto['descripcion']) ?></td>
                    <td><?= esc($producto['categoria_descripcion']) ?></td>
                    <td>$<?= number_format($producto['precio'], 2) ?></td>
                    <td><?= $producto['stock'] ?></td>
                    <td>
                        <?php if (!empty($producto['imagen'])): ?>
                            <img src="<?= base_url($producto['imagen']) ?>" alt="Imagen producto" style="max-width: 80px;">
                        <?php else: ?>
                            <span>No hay imagen</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="<?= base_url('back/productos/editar/' . $producto['id']) ?>">Editar</a> |
                        <a href="<?= base_url('back/productos/eliminar/' . $producto['id']) ?>" onclick="return confirm('¿Estás seguro de eliminar este producto?')">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else : ?>
            <tr><td colspan="8">No hay productos.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<?= $this->endSection() ?>
