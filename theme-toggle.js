document.addEventListener('DOMContentLoaded', function() {
  const toggle = document.getElementById('theme-toggle');
  const icon = document.getElementById('theme-icon');
  const body = document.body;

  // Load saved theme
  if (localStorage.getItem('theme') === 'dark' || 
      (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
    body.classList.add('dark-mode');
    icon.textContent = '☀️';
  } else {
    icon.textContent = '🌙';
  }

  toggle.addEventListener('click', function() {
    body.classList.toggle('dark-mode');
    
    if (body.classList.contains('dark-mode')) {
      icon.textContent = '☀️';
      localStorage.setItem('theme', 'dark');
    } else {
      icon.textContent = '🌙';
      localStorage.removeItem('theme');
    }
  });

  // Navbar compatibility for small screens
  const navbar = document.querySelector('.navbar');
  if (navbar && window.innerWidth < 768) {
    navbar.style.left = '0';
  }
  window.addEventListener('resize', function() {
    if (window.innerWidth < 768) {
      navbar.style.left = '0';
    } else {
      navbar.style.left = '280px';
    }
  });
});
