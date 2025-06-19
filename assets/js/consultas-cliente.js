/**
 * @fileoverview Gestión de consultas del cliente en el frontend
 * Este archivo maneja la visualización de detalles de consultas y la confirmación
 * para eliminar consultas mediante modales de Bootstrap.
 */

document.addEventListener('DOMContentLoaded', function() {
    // Inicialización de elementos para ver detalle de consulta
    const botonesVerConsulta = document.querySelectorAll('.ver-consulta');
    const modalConsulta = new bootstrap.Modal(document.getElementById('modalConsulta'));
    
    // Inicialización de elementos para el modal de confirmación de eliminación
    const modalConfirmarEliminar = new bootstrap.Modal(document.getElementById('modalConfirmarEliminar'));
    const botonesEliminarConsulta = document.querySelectorAll('.eliminar-consulta');
    const btnConfirmarEliminar = document.getElementById('btn-confirmar-eliminar');
    
    /**
     * Formatea una fecha en string al formato local español
     * @param {string} fechaStr - Fecha en formato string
     * @return {string} Fecha formateada
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
     * Formatea el estado de una consulta como un badge HTML
     * @param {string} estado - Estado de la consulta ('pendiente', 'respondida', 'archivada')
     * @return {string} HTML con el badge correspondiente al estado
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
    
    // Configuración de eventos para ver detalle de consulta
    botonesVerConsulta.forEach(boton => {
        boton.addEventListener('click', function() {
            const consultaId = this.getAttribute('data-id');
            
            // Petición AJAX para obtener detalles de la consulta
            fetch(`${baseUrl}/front/cliente/detalle_consulta/${consultaId}`)
                .then(response => response.json())
                .then(data => {
                    // Actualización del contenido del modal con los datos recibidos
                    document.getElementById('consulta-asunto').textContent = data.consulta.asunto;
                    document.getElementById('consulta-estado').innerHTML = formatearEstado(data.consulta.estado);
                    document.getElementById('consulta-mensaje').textContent = data.consulta.mensaje;
                    document.getElementById('consulta-fecha').textContent = formatearFecha(data.consulta.fecha_creacion);
                    
                    // Mostrar el modal con los detalles
                    modalConsulta.show();
                })
                
        });
    });
    
    // Configuración de eventos para eliminar consulta
    botonesEliminarConsulta.forEach(boton => {
        boton.addEventListener('click', function() {
            const consultaId = this.getAttribute('data-id');
            // Configurar la URL de eliminación en el botón de confirmación
            btnConfirmarEliminar.href = `${baseUrl}/front/cliente/eliminar_consulta/${consultaId}`;
            // Mostrar el modal de confirmación
            modalConfirmarEliminar.show();
        });
    });
});