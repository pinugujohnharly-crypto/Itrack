<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>T-Tracks</title>
  <link rel="stylesheet" href="style/hmmenu.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    .trimexlogo a {
      text-decoration: none;
      color: black;
      padding: 6px 12px;
      border-radius: 4px;
      transition: background-color 0.2s ease;
    }

    /* Dropdown login box */
    .login-dropdown {
      display: none;
      position: absolute;
      right: 30px;
      top: 50px;
      transform: translateX(-90px);
      background-color: white;
      padding: 20px;
      border: 1px solid #ccc;
      border-radius: 10px;
      width: 250px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
      z-index: 100;
    }

    .login-dropdown input {
      width: 90%;
      padding: 8px;
      margin: 6px 0;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 14px;
    }

    .login-dropdown button[type="submit"] {
      width: 100%;
      padding: 8px;
      border: none;
      background-color: red;
      color: white;
      border-radius: 5px;
      cursor: pointer;
      font-size: 15px;
    }

    .login-dropdown button[type="submit"]:hover {
      background-color: darkred;
    }

    .auth-links {
      position: relative;
    }

    /* Password wrapper (no Bootstrap) */
    .password-wrappers {
      position: relative;
    }

    .password-wrappers input {
      width: 80%;
      padding-right: 35px; /* space for the icon */
    }

    .toggle-password-btn {
      position: absolute;
      right: 8px;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      color: #777;
      cursor: pointer;
      font-size: 16px;
      padding: 0;
    }

    .toggle-password-btn:hover {
      color: #000;
    }

    .auth-links a {
      text-decoration: none;
      color: black;
      margin-left: 15px;
      font-weight: bold;
    }

    .auth-links a:hover {
      color: red;
    }
  </style>
</head>
<body>

<div class="navbar">
  <div class="trimexlogo">
    <a href="homescreen.php">CAPSTONE TRACKER</a>
  </div>
  <div class="auth-links">
    <a href="#" id="loginBtn" class="login">Log in</a>
    <a href="Signup.php" class="signup">Sign up</a>

    <!-- Dropdown Login -->
    <div id="loginBox" class="login-dropdown">
      <form action="api/login_process.php" method="POST">
        <input type="text" name="username" placeholder="Username" required>

        <div class="password-wrappers">
          <input type="password" id="password" name="password" placeholder="Password" required />
          <button type="button" id="togglePassword" class="toggle-password-btn">
            <i class="fa-solid fa-eye"></i>
          </button>
        </div>

        <button type="submit">Login</button>
      </form>
    </div>
  </div>
</div>

<script>
  // Toggle dropdown visibility
  const loginBtn = document.getElementById('loginBtn');
  const loginBox = document.getElementById('loginBox');

  loginBtn.addEventListener('click', function(e) {
    e.preventDefault();
    loginBox.style.display = loginBox.style.display === 'block' ? 'none' : 'block';
  });

  window.addEventListener('click', function(e) {
    if (!loginBox.contains(e.target) && e.target !== loginBtn) {
      loginBox.style.display = 'none';
    }
  });

  // Password visibility toggle
  document.getElementById('togglePassword').addEventListener('click', function() {
    const passwordInput = document.getElementById('password');
    const icon = this.querySelector('i');
    const isPassword = passwordInput.getAttribute('type') === 'password';
    passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
    icon.classList.toggle('fa-eye');
    icon.classList.toggle('fa-eye-slash');
  });
</script>

</body>
</html>
