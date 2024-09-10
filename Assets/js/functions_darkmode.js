  // JavaScript para alternar el tema y recordar la preferencia
  const toggleThemeButton = document.getElementById('toggle-theme'); // Selecciona el botón de alternancia
  const currentTheme = localStorage.getItem('theme'); // Obtiene el tema actual del almacenamiento local

  // Aplicar el tema almacenado al cargar la página
  if (currentTheme) {
    document.body.setAttribute('data-bs-theme', currentTheme); // Aplica el tema actual al body
    if (currentTheme === 'dark') {
      toggleThemeButton.querySelector('i').classList.replace('bi-moon', 'bi-moon-fill'); // Cambia el ícono a 'bi-moon-fill' si el tema es oscuro
    }
  }

  // Cambiar el tema cuando se hace clic en el botón
  toggleThemeButton.addEventListener('click', (event) => {
    event.preventDefault(); // Previene la acción predeterminada del enlace
    const currentTheme = document.body.getAttribute('data-bs-theme'); // Obtiene el tema actual aplicado al body
    const newTheme = currentTheme === 'dark' ? 'light' : 'dark'; // Alterna el tema entre 'dark' y 'light'
    document.body.setAttribute('data-bs-theme', newTheme); // Aplica el nuevo tema al body
    localStorage.setItem('theme', newTheme); // Guarda el nuevo tema en el almacenamiento local

    // Alternar el ícono del botón
    const icon = toggleThemeButton.querySelector('i'); // Selecciona el ícono dentro del botón
    if (newTheme === 'dark') {
      icon.classList.replace('bi-moon', 'bi-moon-fill'); // Cambia el ícono a 'bi-moon-fill' si el nuevo tema es oscuro
    } else {
      icon.classList.replace('bi-moon-fill', 'bi-moon'); // Cambia el ícono a 'bi-moon' si el nuevo tema es claro
    }
  });