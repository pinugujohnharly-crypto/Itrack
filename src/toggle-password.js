document.addEventListener('DOMContentLoaded', () => {
  const toggleBtn = document.getElementById('togglePassword');
  const passwordInput = document.getElementById('password');
  const icon = toggleBtn.querySelector('i');

  if (toggleBtn && passwordInput && icon) {
    toggleBtn.addEventListener('click', () => {
      const isPassword = passwordInput.type === 'password';
      passwordInput.type = isPassword ? 'text' : 'password';

      // Toggle glyphicon class
      icon.classList.toggle('glyphicon-eye-open', !isPassword);
      icon.classList.toggle('glyphicon-eye-close', isPassword);
    });
  } else {
    console.error('Toggle button or icon not found.');
  }
});
