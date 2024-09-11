// JavaScript para alternar el tema y recordar la preferencia
document.addEventListener('DOMContentLoaded', () => {
    const toggleThemeButton = document.getElementById('theme-selector');
    
    // Función para actualizar el tema y el ícono del botón
    function updateTheme(theme) {
        document.body.setAttribute('data-bs-theme', theme);
        localStorage.setItem('theme', theme);
        updateButton(theme);
    }
  
    function updateButton(theme) {
        const icon = toggleThemeButton.querySelector('i');
        if (theme === 'dark') {
            icon.classList.replace('bi-cloud-sun-fill', 'bi-cloud-moon-fill');
        } else {
            icon.classList.replace('bi-cloud-moon-fill', 'bi-cloud-sun-fill');
        }
    }
  
    // Determinar el tema al cargar la página
    const currentTheme = localStorage.getItem('theme');
    if (currentTheme) {
        updateTheme(currentTheme);
    } else {
        // Aplicar el tema claro por defecto si no hay tema almacenado
        updateTheme('light');
    }
  
    // Cambiar el tema cuando se hace clic en el botón
    toggleThemeButton.addEventListener('click', (event) => {
        event.preventDefault(); // Previene la acción predeterminada del enlace
        const currentTheme = document.body.getAttribute('data-bs-theme');
        const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
        updateTheme(newTheme);
    });
  });
  