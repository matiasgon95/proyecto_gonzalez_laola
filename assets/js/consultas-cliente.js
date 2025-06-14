// Manejo de consultas del cliente
document.addEventListener('DOMContentLoaded', function() {
    // Botones para ver detalle de consulta
    const botonesVerConsulta = document.querySelectorAll('.ver-consulta');
    const modalConsulta = new bootstrap.Modal(document.getElementById('modalConsulta'));
    
    // Modal de confirmación para eliminar
    const modalConfirmarEliminar = new bootstrap.Modal(document.getElementById('modalConfirmarEliminar'));
    const botonesEliminarConsulta = document.querySelectorAll('.eliminar-consulta');
    const btnConfirmarEliminar = document.getElementById('btn-confirmar-eliminar');
    
    // Función para formatear la fecha
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
    
    // Función para formatear el estado
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
    
    // Evento para ver detalle de consulta
    botonesVerConsulta.forEach(boton => {
        boton.addEventListener('click', function() {
            const consultaId = this.getAttribute('data-id');
            
            // Usar la variable global baseUrl definida en el layout
            fetch(`${baseUrl}/front/cliente/detalle_consulta/${consultaId}`)
                .then(response => response.json())
                .then(data => {
                    // Llenar el modal con los datos
                    document.getElementById('consulta-asunto').textContent = data.consulta.asunto;
                    document.getElementById('consulta-estado').innerHTML = formatearEstado(data.consulta.estado);
                    document.getElementById('consulta-mensaje').textContent = data.consulta.mensaje;
                    document.getElementById('consulta-fecha').textContent = formatearFecha(data.consulta.fecha_creacion);
                    
                    // Mostrar el modal
                    modalConsulta.show();
                })
                .catch(error => {
                    console.error('Error al obtener los detalles de la consulta:', error);
                    alert('Error al cargar los detalles de la consulta');
                });
        });
    });
    
    // Evento para eliminar consulta
    botonesEliminarConsulta.forEach(boton => {
        boton.addEventListener('click', function() {
            const consultaId = this.getAttribute('data-id');
            btnConfirmarEliminar.href = `${baseUrl}/front/cliente/eliminar_consulta/${consultaId}`;
            modalConfirmarEliminar.show();
        });
    });
});