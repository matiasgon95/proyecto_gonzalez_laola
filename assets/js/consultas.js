/**
 * @fileoverview Sistema de gestión de consultas para el panel de administración
 * Este script maneja la visualización, selección, filtrado y acciones sobre las consultas
 * de los usuarios, incluyendo cambios de estado, eliminación y acciones masivas.
 */

/**
 * Inicializa la funcionalidad de selección de consultas y acciones masivas
 * - Configura el selector "marcar todos"
 * - Habilita/deshabilita el botón de aplicar según la selección
 * - Implementa confirmación antes de eliminar consultas
 */
function initConsultasSelection() {
    // Selector para marcar/desmarcar todos
    const seleccionarTodos = document.getElementById('seleccionarTodos');
    const checkboxes = document.querySelectorAll('.consulta-check');
    const btnAplicar = document.getElementById('btnAplicar');
    const formAccionMasiva = document.getElementById('formAccionMasiva');
    
    // Si no existen los elementos, no ejecutar el código
    if (!seleccionarTodos || !checkboxes.length || !btnAplicar || !formAccionMasiva) return;
    
    /**
     * Verifica si hay checkboxes seleccionados y habilita/deshabilita el botón de aplicar
     */
    function verificarSeleccionados() {
        const haySeleccionados = Array.from(checkboxes).some(checkbox => checkbox.checked);
        btnAplicar.disabled = !haySeleccionados;
    }
    
    // Evento para seleccionar/deseleccionar todos
    seleccionarTodos.addEventListener('change', function() {
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        verificarSeleccionados();
    });
    
    // Evento para cada checkbox individual
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', verificarSeleccionados);
    });
    
    // Confirmar antes de enviar el formulario si la acción es eliminar
    formAccionMasiva.addEventListener('submit', function(e) {
        const accion = document.querySelector('select[name="accion"]').value;
        if (accion === 'eliminar') {
            if (!confirm('¿Estás seguro de eliminar las consultas seleccionadas? Esta acción no se puede deshacer.')) {
                e.preventDefault();
            }
        }
    });
}

/**
 * Formatea una fecha ISO a formato local español
 * @param {string} fechaStr - Fecha en formato ISO o compatible con Date
 * @returns {string} Fecha formateada en formato local (DD/MM/YYYY HH:MM)
 */
function formatearFecha(fechaStr) {
    const fecha = new Date(fechaStr);
    return fecha.toLocaleString('es-ES', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
}

/**
 * Genera un badge HTML según el estado de la consulta
 * @param {string} estado - Estado de la consulta ('pendiente', 'respondida', 'archivada')
 * @returns {string} HTML con el badge correspondiente al estado
 */
function formatearEstado(estado) {
    switch(estado) {
        case 'pendiente':
            return '<span class="badge bg-warning text-dark">Pendiente</span>';
        case 'respondida':
            return '<span class="badge bg-success">Respondida</span>';
        case 'archivada':
            return '<span class="badge bg-secondary">Archivada</span>';
        default:
            return '<span class="badge bg-info">Desconocido</span>';
    }
}

/**
 * Genera un badge HTML según el tipo de usuario
 * @param {string} esRegistrado - Indica si el usuario está registrado ('si' o 'no')
 * @returns {string} HTML con el badge correspondiente al tipo de usuario
 */
function formatearTipoUsuario(esRegistrado) {
    if (esRegistrado === 'si') {
        return '<span class="badge bg-primary">Cliente Registrado</span>';
    } else {
        return '<span class="badge bg-info text-dark">Visitante</span>';
    }
}

/**
 * Inicializa los modales para ver detalles de consultas y confirmar eliminación
 * - Configura los eventos para los botones de ver consulta
 * - Carga los detalles de la consulta mediante AJAX
 * - Genera botones de acción según el estado actual
 * - Configura los eventos para eliminar consultas
 */
function initConsultasModals() {
    // Botones para ver detalle de consulta
    const botonesVerConsulta = document.querySelectorAll('.ver-consulta');
    const modalConsulta = document.getElementById('modalConsulta');
    
    // Modal de confirmación para eliminar
    const modalConfirmarEliminar = document.getElementById('modalConfirmarEliminar');
    const botonesEliminarConsulta = document.querySelectorAll('.eliminar-consulta');
    const btnConfirmarEliminar = document.getElementById('btn-confirmar-eliminar');
    
    // Si no existen los elementos, no ejecutar el código
    if (!modalConsulta || !botonesVerConsulta.length) return;
    
    // Inicializar modales con Bootstrap
    const modalConsultaBS = new bootstrap.Modal(modalConsulta);
    const modalConfirmarEliminarBS = modalConfirmarEliminar ? new bootstrap.Modal(modalConfirmarEliminar) : null;
    
    // Evento para ver detalle de consulta
    botonesVerConsulta.forEach(boton => {
        boton.addEventListener('click', function() {
            const consultaId = this.getAttribute('data-id');
            
            // Usar la variable global baseUrl definida en el layout
            fetch(`${baseUrl}/back/consultas/getDetalleConsulta/${consultaId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        alert(data.error);
                        return;
                    }
                    
                    // Llenar el modal con los datos
                    document.getElementById('consulta-nombre').textContent = `${data.consulta.nombre} ${data.consulta.apellido}`;
                    document.getElementById('consulta-email').textContent = data.consulta.email;
                    document.getElementById('consulta-asunto').textContent = data.consulta.asunto;
                    document.getElementById('consulta-tipo').innerHTML = formatearTipoUsuario(data.consulta.es_registrado);
                    document.getElementById('consulta-estado').innerHTML = formatearEstado(data.consulta.estado);
                    document.getElementById('consulta-mensaje').innerHTML = data.consulta.mensaje.replace(/\n/g, '<br>');
                    document.getElementById('consulta-fecha').textContent = formatearFecha(data.consulta.fecha_creacion);
                    
                    // Generar botones de acción según el estado
                    const accionesContainer = document.getElementById('consulta-acciones');
                    accionesContainer.innerHTML = '';
                    
                    // Botones según el estado
                    if (data.consulta.estado === 'pendiente' || data.consulta.estado === 'respondida') {
                        accionesContainer.innerHTML += `
                            <a href="${baseUrl}/back/consultas/cambiarEstado/${data.consulta.id}/archivada" class="btn btn-secondary">
                                <i class="fas fa-archive me-2"></i>Archivar
                            </a>
                        `;
                    }
                    
                    if (data.consulta.estado === 'pendiente') {
                        accionesContainer.innerHTML += `
                            <a href="${baseUrl}/back/consultas/cambiarEstado/${data.consulta.id}/respondida" class="btn btn-success">
                                <i class="fas fa-check me-2"></i>Marcar como respondida
                            </a>
                        `;
                    }
                    
                    if (data.consulta.estado === 'archivada') {
                        accionesContainer.innerHTML += `
                            <a href="${baseUrl}/back/consultas/cambiarEstado/${data.consulta.id}/pendiente" class="btn btn-warning">
                                <i class="fas fa-undo me-2"></i>Restaurar como pendiente
                            </a>
                        `;
                    }
                    
                    // Botón de eliminar siempre presente
                    accionesContainer.innerHTML += `
                        <button type="button" class="btn btn-danger eliminar-consulta-modal" data-id="${data.consulta.id}">
                            <i class="fas fa-trash-alt me-2"></i>Eliminar
                        </button>
                    `;
                    
                    // Añadir evento al botón de eliminar dentro del modal
                    const btnEliminarModal = accionesContainer.querySelector('.eliminar-consulta-modal');
                    if (btnEliminarModal) {
                        btnEliminarModal.addEventListener('click', function() {
                            const consultaId = this.getAttribute('data-id');
                            modalConsultaBS.hide();
                            if (modalConfirmarEliminarBS) {
                                btnConfirmarEliminar.href = `${baseUrl}/back/consultas/eliminar/${consultaId}`;
                                modalConfirmarEliminarBS.show();
                            } else {
                                if (confirm('¿Estás seguro de eliminar esta consulta? Esta acción no se puede deshacer.')) {
                                    window.location.href = `${baseUrl}/back/consultas/eliminar/${consultaId}`;
                                }
                            }
                        });
                    }
                    
                    // Mostrar el modal
                    modalConsultaBS.show();
                })
                .catch(error => {
                    console.error('Error al obtener los detalles de la consulta:', error);
                    alert('Error al cargar los detalles de la consulta');
                });
        });
    });
    
    // Evento para eliminar consulta
    if (botonesEliminarConsulta.length && modalConfirmarEliminarBS && btnConfirmarEliminar) {
        botonesEliminarConsulta.forEach(boton => {
            boton.addEventListener('click', function() {
                const consultaId = this.getAttribute('data-id');
                btnConfirmarEliminar.href = `${baseUrl}/back/consultas/eliminar/${consultaId}`;
                modalConfirmarEliminarBS.show();
            });
        });
    }
}

// Inicializar cuando el DOM esté cargado
document.addEventListener('DOMContentLoaded', function() {
    initConsultasSelection();
    initConsultasModals();
});