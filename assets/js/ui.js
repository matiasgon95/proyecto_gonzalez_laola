/**
 * Script para manejar elementos de la interfaz de usuario
 */

// Función para inicializar el menú contraíble de categorías
function initCategoryMenu() {
    const toggleBtn = document.getElementById('toggleCategories');
    const categoriesList = document.getElementById('categoriesList');
    const categoryIcon = document.getElementById('categoryIcon');
    
    // Si no existen los elementos, no ejecutar el código
    if (!toggleBtn || !categoriesList || !categoryIcon) return;
    
    // Verificar si hay una preferencia guardada en localStorage
    const isCategoriesCollapsed = localStorage.getItem('categoriesCollapsed') === 'true';
    
    // Aplicar el estado inicial según la preferencia guardada
    if (isCategoriesCollapsed) {
        categoriesList.style.display = 'none';
        categoryIcon.classList.remove('fa-chevron-up');
        categoryIcon.classList.add('fa-chevron-down');
    }
    
    // Manejar el clic en el botón de alternar
    toggleBtn.addEventListener('click', function() {
        if (categoriesList.style.display === 'none') {
            categoriesList.style.display = 'block';
            categoryIcon.classList.remove('fa-chevron-down');
            categoryIcon.classList.add('fa-chevron-up');
            localStorage.setItem('categoriesCollapsed', 'false');
        } else {
            categoriesList.style.display = 'none';
            categoryIcon.classList.remove('fa-chevron-up');
            categoryIcon.classList.add('fa-chevron-down');
            localStorage.setItem('categoriesCollapsed', 'true');
        }
    });
}

// Inicializar cuando el DOM esté cargado
document.addEventListener('DOMContentLoaded', function() {
    initCategoryMenu();
    
    // Aquí puedes agregar más inicializaciones de UI en el futuro
});