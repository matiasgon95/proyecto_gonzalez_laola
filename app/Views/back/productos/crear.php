<?= $this->extend('front/layout/layouts') ?>
<?= $this->section('contenedor') ?>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow border border-info">
                <div class="card-header bg-info text-black text-center rounded-top">
                    <h1 class="h3 mb-0">Crear Producto</h1>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('back/productos/guardar') ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control bg-dark text-info border-info" name="nombre" id="nombre" required>
                        </div>

                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control bg-dark text-info border-info" name="descripcion" id="descripcion" rows="4"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="precio" class="form-label">Precio</label>
                            <div class="input-group">
                                <span class="input-group-text bg-dark text-info border-info">$</span>
                                <input type="number" class="form-control bg-dark text-info border-info" name="precio" id="precio" step="0.01" min="0" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="categoria" class="form-label">Categoría</label>
                            <select class="form-select bg-dark text-info border-info" name="categoria" id="categoria" required>
                                <option value="">-- Seleccione una categoría --</option>
                                <?php foreach ($categorias as $cat): ?>
                                    <option value="<?= esc($cat['id']) ?>"><?= esc($cat['descripcion']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="stock" class="form-label">Stock</label>
                            <input type="number" class="form-control bg-dark text-info border-info" name="stock" id="stock" min="0" value="0" required>
                        </div>

                        <div class="mb-4">
                            <label for="imagen" class="form-label">Imagen</label>
                            <input type="file" class="form-control bg-dark text-info border-info" name="imagen" id="imagen" accept="image/*">
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="<?= base_url('back/productos') ?>" class="btn btn-outline-info rounded-pill px-4">Cancelar</a>
                            <button type="submit" class="btn btn-info text-black rounded-pill px-4">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
