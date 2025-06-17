<?= $this->extend('front/layout/layouts'); ?> <!-- Extiende la plantilla principal de layouts -->

<?= $this->section('contenedor'); ?> <!-- Inicia la sección 'contenedor' que se insertará en la plantilla -->

<!-- Contenedor principal con fondo oscuro y texto en color info (azul claro) -->
<div class="container-fluid py-5 bg-dark text-info">
    <div class="container-fluid px-4">
        <div class="row justify-content-center">
            <div class="col-12">
                <!-- Tarjeta principal que contiene toda la información de consultas -->
                <div class="card bg-dark border-info mb-4">
                    <div class="card-body text-info">
                        <!-- Encabezado con título y botones de acción -->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h1 class="display-5"><?= $titulo ?></h1>
                            <div>
                                <!-- Botón para crear una nueva consulta -->
                                <a href="<?= base_url('front/cliente/nueva_consulta') ?>" class="btn btn-info rounded-pill px-4 me-2">
                                    <i class="fas fa-plus"></i> Nueva Consulta
                                </a>
                                <!-- Botón para volver al panel de cliente -->
                                <a href="<?= base_url('front/cliente/dashboard') ?>" class="btn btn-outline-info rounded-pill px-4">
                                    <i class="fas fa-arrow-left"></i> Volver al Panel
                                </a>
                            </div>
                        </div>
                        
                        <!-- Sistema de notificaciones: Mensaje de éxito -->
                        <?php if (session()->getFlashdata('mensaje')) : ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <?= session()->getFlashdata('mensaje') ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Sistema de notificaciones: Mensaje de error -->
                        <?php if (session()->getFlashdata('error')) : ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?= session()->getFlashdata('error') ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Contenedor de tabla responsive para adaptarse a diferentes tamaños de pantalla -->
                        <div class="table-responsive">
                            <!-- Manejo condicional: Mensaje cuando no hay consultas -->
                            <?php if (empty($consultas)) : ?>
                                <div class="alert alert-info text-center">
                                    No tienes consultas realizadas. Puedes crear una nueva desde la sección de contacto.
                                </div>
                            <!-- Tabla de consultas cuando hay datos disponibles -->
                            <?php else : ?>
                                <table class="table table-dark table-hover table-bordered table-consultas">
                                    <thead class="bg-info text-dark">
                                        <tr>
                                            <th class="text-center">Fecha</th>
                                            <th class="text-center">Asunto</th>
                                            <th class="text-center">Estado</th>
                                            <th class="text-center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Iteración sobre cada consulta del cliente -->
                                        <?php foreach ($consultas as $consulta) : ?>
                                            <tr>
                                                <!-- Fecha formateada -->
                                                <td class="text-center align-middle"><?= date('d/m/Y H:i', strtotime($consulta->fecha_creacion)) ?></td>
                                                <td class="align-middle"><?= $consulta->asunto ?></td>
                                                <!-- Estado con indicador visual (badge) según el valor -->
                                                <td class="text-center align-middle">
                                                    <?php if ($consulta->estado == 'pendiente') : ?>
                                                        <span class="badge bg-warning text-dark">Pendiente</span>
                                                    <?php elseif ($consulta->estado == 'respondida') : ?>
                                                        <span class="badge bg-success">Respondida</span>
                                                    <?php elseif ($consulta->estado == 'archivada') : ?>
                                                        <span class="badge bg-secondary">Archivada</span>
                                                    <?php endif; ?>
                                                </td>
                                                <!-- Botones de acción para cada consulta -->
                                                <td class="text-center align-middle">
                                                    <div class="btn-group">
                                                        <!-- Botón para ver detalles (abre modal) -->
                                                        <button type="button" class="btn btn-info btn-sm ver-consulta" data-id="<?= $consulta->id ?>" title="Ver detalles">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                        <!-- Botón para eliminar (abre modal de confirmación) -->
                                                        <button type="button" class="btn btn-danger btn-sm eliminar-consulta" data-id="<?= $consulta->id ?>" title="Eliminar">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para ver detalle de consulta - Se activa al hacer clic en el botón de ver detalles -->
<div class="modal fade" id="modalConsulta" tabindex="-1" aria-labelledby="modalConsultaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content bg-dark text-info">
            <div class="modal-header">
                <h5 class="modal-title" id="modalConsultaLabel">Detalle de Consulta</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Información del asunto y estado de la consulta -->
                <div class="row mb-3">
                    <div class="col-md-6 text-center">
                        <p><strong>Asunto:</strong> <span id="consulta-asunto"></span></p>
                    </div>
                    <div class="col-md-6 text-center">
                        <p><strong>Estado:</strong> <span id="consulta-estado"></span></p>
                    </div>
                </div>
                <!-- Contenido del mensaje de la consulta -->
                <div class="row mb-3">
                    <div class="col-md-12">
                        <p class="text-center"><strong>Mensaje:</strong></p>
                        <div class="p-3 bg-dark border border-info rounded" id="consulta-mensaje"></div>
                    </div>
                </div>
                <!-- Fecha de creación de la consulta -->
                <div class="row">
                    <div class="col-md-6 mx-auto text-center">
                        <p><strong>Fecha de creación:</strong> <span id="consulta-fecha"></span></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para confirmar eliminación de consulta - Se activa al hacer clic en el botón de eliminar -->
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
                <!-- El enlace se actualiza dinámicamente con JavaScript para incluir el ID de la consulta a eliminar -->
                <a href="#" id="btn-confirmar-eliminar" class="btn btn-danger">Eliminar</a>
            </div>
        </div>
    </div>
</div>

<!-- Incluir el script específico para la funcionalidad de consultas del cliente -->
<script src="<?= base_url('assets/js/consultas-cliente.js') ?>"></script>

<?= $this->endSection(); ?> <!-- Finaliza la sección 'contenedor' -->