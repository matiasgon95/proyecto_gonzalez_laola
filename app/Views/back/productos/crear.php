<?= $this->extend('front/layout/layouts') ?>
<?= $this->section('contenedor') ?>

<h1>Crear Producto</h1>

<form action="<?= base_url('back/productos/guardar') ?>" method="post" enctype="multipart/form-data">
<?= csrf_field() ?>
    <label for="nombre">Nombre:</label><br>
    <input type="text" name="nombre" id="nombre" required><br><br>

    <label for="descripcion">Descripción:</label><br>
    <textarea name="descripcion" id="descripcion" rows="4"></textarea><br><br>

    <label for="precio">Precio:</label><br>
    <input type="number" name="precio" id="precio" step="0.01" min="0" required><br><br>

    <label for="categoria">Categoría:</label><br>
    <select name="categoria" id="categoria" required>
        <option value="">-- Seleccione una categoría --</option>
        <?php foreach ($categorias as $cat): ?>
            <option value="<?= esc($cat['id']) ?>"><?= esc($cat['descripcion']) ?></option>
        <?php endforeach; ?>
    </select><br><br>

    <label for="stock">Stock:</label><br>
    <input type="number" name="stock" id="stock" min="0" value="0" required><br><br>

    <label for="imagen">Imagen:</label><br>
    <input type="file" name="imagen" id="imagen" accept="image/*"><br><br>

    <button type="submit">Guardar</button>
    <a href="<?= base_url('productos') ?>">Cancelar</a>

</form>

<?= $this->endSection() ?>
