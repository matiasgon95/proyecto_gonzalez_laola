document.addEventListener('DOMContentLoaded', function() {
    // Buscar todos los botones de toggle password en la página
    const toggleButtons = document.querySelectorAll('[id^="togglePassword"]');
    
    toggleButtons.forEach(function(toggleButton) {
        toggleButton.addEventListener('click', function() {
            // Encontrar el campo de contraseña asociado (asumiendo que está en el mismo grupo de input)
            const inputGroup = this.closest('.input-group');
            const passwordInput = inputGroup.querySelector('input[type="password"], input[type="text"]');
            const eyeIcon = this.querySelector('i');
            
            if (!passwordInput || !eyeIcon) return;
            
            // Cambiar el tipo de input entre password y text
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            // Cambiar el ícono entre ojo y ojo tachado
            if (type === 'text') {
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        });
    });
});