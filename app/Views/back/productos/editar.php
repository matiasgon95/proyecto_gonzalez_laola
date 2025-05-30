<?= $this->extend('front/layout/layouts') ?>
<?= $this->section('contenedor') ?>

<h1>Editar Producto</h1>

<form action="<?= base_url('back/productos/actualizar/' . $producto['id']) ?>" method="post" enctype="multipart/form-data">
<?= csrf_field() ?>
    <label for="nombre">Nombre:</label><br>
    <input type="text" name="nombre" id="nombre" value="<?= esc($producto['nombre']) ?>" required><br><br>

    <label for="descripcion">Descripción:</label><br>
    <textarea name="descripcion" id="descripcion" rows="4"><?= esc($producto['descripcion']) ?></textarea><br><br>

    <label for="precio">Precio:</label><br>
    <input type="number" name="precio" id="precio" step="0.01" min="0" value="<?= esc($producto['precio']) ?>" required><br><br>

    <label for="categoria">Categoría:</label><br>
        <select name="categoria" id="categoria" required>
            <option value="">-- Seleccione una categoría --</option>
            <?php foreach ($categorias as $cat): ?>
                <option value="<?= esc($cat['id']) ?>" <?= (isset($producto) && $producto['categoria_id'] == $cat['id']) ? 'selected' : '' ?>>
                    <?= esc($cat['descripcion']) ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>



    <label for="stock">Stock:</label><br>
    <input type="number" name="stock" id="stock" min="0" value="<?= esc($producto['stock']) ?>" required><br><br>

    <label for="imagen">Imagen actual:</label><br>
    <?php if ($producto['imagen']): ?>
        <input type="hidden" name="imagen_actual" value="<?= esc($producto['imagen']) ?>">
        <img src="<?= base_url($producto['imagen']) ?>" alt="Imagen producto" style="max-width: 200px; display: block; margin-bottom: 10px;">
    <?php else: ?>
        <p>No hay imagen subida.</p>
    <?php endif; ?>

    <label for="imagen">Cambiar imagen:</label><br>
    <input type="file" name="imagen" id="imagen" accept="image/*"><br><br>

    <button type="submit">Actualizar</button>
    <a href="<?= base_url('productos') ?>">Cancelar</a>

</form>

<?= $this->endSection() ?>
