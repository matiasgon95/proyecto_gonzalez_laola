<?= $this->extend('front/layout/layouts') ?>
<?= $this->section('contenedor') ?>

<div class="container-fluid py-5 bg-dark text-info">
    <div class="container-fluid px-4"> <!-- Cambiado de container a container-fluid para usar todo el ancho -->
        <div class="row justify-content-center">
            <div class="col-12"> <!-- Cambiado de col-lg-10 a col-12 para usar todo el ancho -->
                <div class="card bg-dark border-info mb-4">
                    <div class="card-body text-info">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h1 class="display-5">Gestión de Consultas</h1>
                            <div>
                                <a href="<?= base_url('back/consultas/archivadas') ?>" class="btn btn-secondary rounded-pill px-4 me-2">
                                    <i class="fas fa-archive"></i> Ver Archivadas
                                </a>
                                <a href="<?= base_url('back/dashboard') ?>" class="btn btn-outline-info rounded-pill px-4">
                                    <i class="fas fa-arrow-left"></i> Volver al Dashboard
                                </a>
                            </div>
                        </div>
                        
                        <?php if (session()->has('mensaje')): ?>
                            <div class="alert alert-success">
                                <?= session('mensaje') ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (session()->has('error')): ?>
                            <div class="alert alert-danger">
                                <?= session('error') ?>
                            </div>
                        <?php endif; ?>
                        
                        <form action="<?= base_url('back/consultas/accionMasiva') ?>" method="post" id="formAccionMasiva">
                            <?= csrf_field() ?>
                            <div class="d-flex justify-content-between mb-3">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="seleccionarTodos">
                                    <label class="form-check-label" for="seleccionarTodos">Seleccionar todos</label>
                                </div>
                                <div class="d-flex">
                                    <select name="accion" class="form-select me-2" required>
                                        <option value="">Seleccionar acción</option>
                                        <option value="respondida">Marcar como respondidas</option>
                                        <option value="archivada">Archivar</option>
                                        <option value="eliminar">Eliminar</option>
                                    </select>
                                    <button type="submit" class="btn btn-info" id="btnAplicar" disabled>
                                        <i class="fas fa-check me-1"></i>Aplicar
                                    </button>
                                </div>
                            </div>
                        
                            <div class="table-responsive">
                                <table class="table table-dark table-hover table-bordered table-consultas"> <!-- Añadida clase table-consultas -->
                                    <thead class="bg-info text-dark">
                                        <tr>
                                            <th class="text-center" style="width: 40px;">Sel</th>
                                            <th class="text-center">ID</th>
                                            <th class="text-center">Nombre</th>
                                            <th class="text-center">Email</th>
                                            <th class="text-center">Asunto</th>
                                            <th class="text-center">Fecha</th>
                                            <th class="text-center">Estado</th>
                                            <th class="text-center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($consultas)): ?>
                                            <tr>
                                                <td colspan="8" class="text-center">No hay consultas registradas</td>
                                            </tr>
                                        <?php else: ?>
                                            <?php foreach ($consultas as $consulta): ?>
                                                <tr>
                                                    <td class="text-center">
                                                        <input class="form-check-input consulta-check" type="checkbox" name="consultas[]" value="<?= $consulta->id ?>">
                                                    </td>
                                                    <td class="text-center"><?= $consulta->id ?></td>
                                                    <td><?= $consulta->nombre ?> <?= $consulta->apellido ?></td>
                                                    <td><?= $consulta->email ?></td>
                                                    <td><?= $consulta->asunto ?></td>
                                                    <td class="text-center"><?= date('d/m/Y H:i', strtotime($consulta->fecha_creacion)) ?></td>
                                                    <td class="text-center">
                                                        <?php if ($consulta->estado == 'pendiente'): ?>
                                                            <span class="badge bg-warning text-dark">Pendiente</span>
                                                        <?php elseif ($consulta->estado == 'respondida'): ?>
                                                            <span class="badge bg-success">Respondida</span>
                                                        <?php else: ?>
                                                            <span class="badge bg-secondary">Archivada</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="btn-group">
                                                            <a href="<?= base_url('back/consultas/ver/' . $consulta->id) ?>" class="btn btn-info btn-sm" title="Ver detalles">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                            <a href="<?= base_url('back/consultas/cambiarEstado/' . $consulta->id . '/respondida') ?>" class="btn btn-success btn-sm" title="Marcar como respondida">
                                                                <i class="fas fa-check"></i>
                                                            </a>
                                                            <a href="<?= base_url('back/consultas/cambiarEstado/' . $consulta->id . '/archivada') ?>" class="btn btn-secondary btn-sm" title="Archivar">
                                                                <i class="fas fa-archive"></i>
                                                            </a>
                                                            <a href="<?= base_url('back/consultas/eliminar/' . $consulta->id) ?>" class="btn btn-danger btn-sm" title="Eliminar" onclick="return confirm('¿Estás seguro de eliminar esta consulta?')">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Incluir el script para la gestión de consultas -->
<script src="<?= base_url('assets/js/consultas.js') ?>"></script>

<?= $this->endSection() ?>