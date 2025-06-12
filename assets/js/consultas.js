/**
 * Script para la gestión de consultas
 */

// Función para inicializar la gestión de selección de consultas
function initConsultasSelection() {
    // Selector para marcar/desmarcar todos
    const seleccionarTodos = document.getElementById('seleccionarTodos');
    const checkboxes = document.querySelectorAll('.consulta-check');
    const btnAplicar = document.getElementById('btnAplicar');
    const formAccionMasiva = document.getElementById('formAccionMasiva');
    
    // Si no existen los elementos, no ejecutar el código
    if (!seleccionarTodos || !checkboxes.length || !btnAplicar || !formAccionMasiva) return;
    
    // Función para verificar si hay checkboxes seleccionados
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
        checkbox.addEventListener('change', function() {
            verificarSeleccionados();
            
            // Actualizar el estado del checkbox "seleccionar todos"
            const todosMarcados = Array.from(checkboxes).every(cb => cb.checked);
            seleccionarTodos.checked = todosMarcados;
        });
    });
    
    // Confirmación antes de enviar el formulario
    formAccionMasiva.addEventListener('submit', function(e) {
        const accion = document.querySelector('select[name="accion"]').value;
        const seleccionados = document.querySelectorAll('.consulta-check:checked').length;
        
        if (accion === 'eliminar') {
            if (!confirm(`¿Estás seguro de eliminar ${seleccionados} consulta(s)?`)) {
                e.preventDefault();
            }
        }
    });
}

// Inicializar cuando el DOM esté cargado
document.addEventListener('DOMContentLoaded', function() {
    initConsultasSelection();
});