  <!-- Footer -->
  <footer class="py-4 border-top bg-white mt-auto">
    <div class="container d-flex flex-wrap justify-content-between align-items-center">
      <span class="text-secondary small">© <span id="y"></span> I‑Tracks — College of Computer Studies</span>
    </div>
  </footer>

  <!-- Login Modal (shared across public pages) -->
  <div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Sign in</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="api/login_process.php" method="POST">
          <div class="modal-body">
            <div class="mb-3">
              <label for="login-username" class="form-label">Username</label>
              <input type="text" id="login-username" name="username" class="form-control" autocomplete="username" required />
            </div>
            <div class="mb-2">
              <label for="login-password" class="form-label">Password</label>
              <div class="input-group">
                <input type="password" id="login-password" name="password" class="form-control" autocomplete="current-password" required />
                <button class="btn btn-outline-secondary" type="button" id="togglePassword" aria-label="Toggle password visibility">
                  <i class="fa-solid fa-eye"></i>
                </button>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-accent">Login</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // year in footer
    (function(){
      var yearEl = document.getElementById('y');
      if (yearEl) yearEl.textContent = new Date().getFullYear();
    })();

    // Password visibility toggle for login modal
    (function(){
      var togglePasswordBtn = document.getElementById('togglePassword');
      var passwordInput = document.getElementById('login-password');
      if (togglePasswordBtn && passwordInput) {
        togglePasswordBtn.addEventListener('click', function () {
          var isPassword = passwordInput.getAttribute('type') === 'password';
          passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
          var icon = this.querySelector('i');
          if (icon) {
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
          }
        });
      }
    })();

    // Optional: password toggle for signup page if present
    (function(){
      var signupToggle = document.getElementById('signup-togglePassword');
      var signupPass = document.getElementById('signup-password');
      if (signupToggle && signupPass) {
        signupToggle.addEventListener('click', function () {
          var isPassword = signupPass.getAttribute('type') === 'password';
          signupPass.setAttribute('type', isPassword ? 'text' : 'password');
          var icon = this.querySelector('i');
          if (icon) {
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
          }
        });
      }
    })();
  </script>
</body>
</html>

