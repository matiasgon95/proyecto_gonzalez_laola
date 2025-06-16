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
                                            <th class="text-center">Tipo</th>
                                            <th class="text-center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($consultas)): ?>
                                            <tr>
                                                <td colspan="9" class="text-center">No hay consultas registradas</td>
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
                                                        <?php if ($consulta->es_registrado == 'si'): ?>
                                                            <span class="badge bg-primary">Registrado</span>
                                                        <?php else: ?>
                                                            <span class="badge bg-info text-dark">Visitante</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-info btn-sm ver-consulta" data-id="<?= $consulta->id ?>" title="Ver detalles">
                                                                <i class="fas fa-eye"></i>
                                                            </button>
                                                            <a href="<?= base_url('back/consultas/cambiarEstado/' . $consulta->id . '/respondida') ?>" class="btn btn-success btn-sm" title="Marcar como respondida">
                                                                <i class="fas fa-check"></i>
                                                            </a>
                                                            <a href="<?= base_url('back/consultas/cambiarEstado/' . $consulta->id . '/archivada') ?>" class="btn btn-secondary btn-sm" title="Archivar">
                                                                <i class="fas fa-archive"></i>
                                                            </a>
                                                            <button type="button" class="btn btn-danger btn-sm eliminar-consulta" data-id="<?= $consulta->id ?>" title="Eliminar">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </button>
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

<!-- Modal para ver detalle de consulta -->
<div class="modal fade" id="modalConsulta" tabindex="-1" aria-labelledby="modalConsultaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content bg-dark text-info">
            <div class="modal-header">
                <h5 class="modal-title" id="modalConsultaLabel">Detalle de Consulta</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p><strong>Nombre:</strong> <span id="consulta-nombre"></span></p>
                        <p><strong>Email:</strong> <span id="consulta-email"></span></p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <p><strong>Asunto:</strong> <span id="consulta-asunto"></span></p>
                        <p><strong>Tipo:</strong> <span id="consulta-tipo"></span></p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p><strong>Fecha:</strong> <span id="consulta-fecha"></span></p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <p><strong>Estado:</strong> <span id="consulta-estado"></span></p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <p class="text-center"><strong>Mensaje:</strong></p>
                        <div class="p-3 bg-dark border border-info rounded" id="consulta-mensaje"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex justify-content-between mt-3" id="consulta-acciones">
                            <!-- Aquí se insertarán los botones de acción dinámicamente -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para confirmar eliminación de consulta -->
<div class="modal fade" id="modalConfirmarEliminar" tabindex="-1" aria-labelledby="modalConfirmarEliminarLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-dark text-info">
            <div class="modal-header">
                <h5 class="modal-title" id="modalConfirmarEliminarLabel">Confirmar Eliminación</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <p>¿Estás seguro de que deseas eliminar esta consulta?</p>
                <p class="text-danger">Esta acción no se puede deshacer.</p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <a href="#" id="btn-confirmar-eliminar" class="btn btn-danger">Eliminar</a>
            </div>
        </div>
    </div>
</div>

<!-- Incluir el script para la gestión de consultas -->
<script src="<?= base_url('assets/js/consultas.js') ?>"></script>

<?= $this->endSection() ?>