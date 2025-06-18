<?php
// Vista para la gestión de consultas archivadas
// Permite visualizar, filtrar y realizar acciones masivas sobre las consultas archivadas
?>
<?= $this->extend('front/layout/layouts') ?>
<?= $this->section('contenedor') ?>

<div class="container-fluid py-5 bg-dark text-info">
    <div class="container-fluid px-4">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card bg-dark border-info mb-4">
                    <div class="card-body text-info">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
                            <h1 class="display-5 mb-3 mb-md-0">Consultas Archivadas</h1>
                            <div>
                                <a href="<?= base_url('back/consultas') ?>" class="btn btn-info rounded-pill px-4 me-2">
                                    <i class="fas fa-inbox"></i> Ver Consultas Activas
                                </a>
                                <a href="<?= base_url('back/dashboard') ?>" class="btn btn-outline-info rounded-pill px-4">
                                    <i class="fas fa-arrow-left"></i> Volver al Panel
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
                        
                        <!-- Formulario para acciones masivas -->
                        <form id="formAccionMasiva" action="<?= base_url('back/consultas/accionMasivaArchivadas') ?>" method="post">
                            <?= csrf_field() ?>
                            <!-- Contenedor de filtros y acciones agrupados -->
                            <div class="card bg-dark border-info mb-3">
                                <div class="card-body p-3">
                                    <div class="row align-items-center">
                                        <!-- Filtros de tipo de consulta -->
                                        <div class="col-md-6 mb-3 mb-md-0">
                                            <div class="btn-group w-100">
                                                <a href="<?= base_url('back/consultas/archivadas') ?>" class="btn btn-info <?= !isset($tipo) ? 'active' : '' ?>">
                                                    <i class="fas fa-list me-1"></i> Todos
                                                </a>
                                                <a href="<?= base_url('back/consultas/archivadas/registrados') ?>" class="btn btn-info <?= isset($tipo) && $tipo == 'registrados' ? 'active' : '' ?>">
                                                    <i class="fas fa-user-check me-1"></i> Clientes
                                                </a>
                                                <a href="<?= base_url('back/consultas/archivadas/visitantes') ?>" class="btn btn-info <?= isset($tipo) && $tipo == 'visitantes' ? 'active' : '' ?>">
                                                    <i class="fas fa-user me-1"></i> Visitantes
                                                </a>
                                            </div>
                                        </div>
                                        <!-- Acciones masivas -->
                                        <div class="col-md-6">
                                            <div class="d-flex align-items-center">
                                                <div class="form-check form-check-inline me-2">
                                                    <input class="form-check-input" type="checkbox" id="seleccionarTodos">
                                                    <label class="form-check-label" for="seleccionarTodos">Seleccionar</label>
                                                </div>
                                                <select name="accion" class="form-select me-2" required>
                                                    <option value="">Acción</option>
                                                    <option value="pendiente">Restaurar como pendiente</option>
                                                    <option value="eliminar">Eliminar</option>
                                                </select>
                                                <button type="submit" class="btn btn-info" id="btnAplicar" disabled>
                                                    <i class="fas fa-check me-1"></i>Aplicar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                            <!-- Tabla de consultas con columnas responsivas -->
                            <div class="table-responsive">
                                <table class="table table-dark table-hover table-bordered table-consultas">
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
                                                <td colspan="9" class="text-center">No hay consultas archivadas</td>
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
                                                        <span class="badge bg-secondary">Archivada</span>
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
                                                            <a href="<?= base_url('back/consultas/cambiarEstado/' . $consulta->id . '/pendiente') ?>" class="btn btn-warning btn-sm" title="Restaurar como pendiente">
                                                                <i class="fas fa-undo"></i>
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

<!-- Modales para interacción con consultas: visualización de detalles y confirmación de eliminación -->
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
<?= $this->endSection() ?>