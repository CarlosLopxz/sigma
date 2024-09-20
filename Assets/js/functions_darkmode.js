// Selecciona el botón de alternancia
const toggleThemeButton = document.getElementById('toggle-theme');

// Aplica el tema almacenado o el tema por defecto
const currentTheme = localStorage.getItem('theme') || 'light';
document.body.setAttribute('data-bs-theme', currentTheme);

// Cambia el ícono si el tema es oscuro
if (currentTheme === 'dark') {
  toggleThemeButton.querySelector('i').classList.replace('bi-moon', 'bi-moon-fill');
}

// Alterna el tema y el ícono cuando se hace clic en el botón
toggleThemeButton.addEventListener('click', () => {
  const newTheme = document.body.getAttribute('data-bs-theme') === 'dark' ? 'light' : 'dark';
  document.body.setAttribute('data-bs-theme', newTheme);
  localStorage.setItem('theme', newTheme);

  // Alterna el ícono
  const icon = toggleThemeButton.querySelector('i');
  icon.classList.toggle('bi-moon-fill');
  icon.classList.toggle('bi-moon');
});
