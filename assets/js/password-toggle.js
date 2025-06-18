/**
 * Módulo de alternancia de visibilidad de contraseñas
 * 
 * Este script permite mostrar u ocultar el texto en campos de contraseña
 * mediante un botón con ícono de ojo, mejorando la experiencia de usuario
 * al permitir verificar visualmente la contraseña ingresada.
 */
document.addEventListener('DOMContentLoaded', function() {
    // Buscar todos los botones de toggle password en la página
    // La convención es que estos botones tengan IDs que comiencen con "togglePassword"
    const toggleButtons = document.querySelectorAll('[id^="togglePassword"]');
    
    // Configurar cada botón encontrado
    toggleButtons.forEach(function(toggleButton) {
        toggleButton.addEventListener('click', function() {
            // Encontrar el campo de contraseña asociado (asumiendo que está en el mismo grupo de input)
            const inputGroup = this.closest('.input-group');
            const passwordInput = inputGroup.querySelector('input[type="password"], input[type="text"]');
            const eyeIcon = this.querySelector('i');
            
            // Verificar que se encontraron los elementos necesarios
            if (!passwordInput || !eyeIcon) return;
            
            // Cambiar el tipo de input entre password y text para mostrar/ocultar la contraseña
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            // Cambiar el ícono entre ojo y ojo tachado para indicar el estado actual
            if (type === 'text') {
                // La contraseña es visible, mostrar ícono de ojo tachado
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                // La contraseña está oculta, mostrar ícono de ojo normal
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        });
    });
});