<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>T-Tracks</title>
<!-- Load Bootstrap FIRST -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">



  <style>
        
        .register-box {
            background: #ffffff;
            padding: 80px 50px;
            width: 400px;
            text-align: center;
            margin: 0 auto; /* horizontally center */
            
           
        }

        .register-box h2 {
            margin-bottom: 20px;
            color: #333;
        }

        .register-box input,
        .register-box select {
            width: 100%;
            padding: 20px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
   .input-group {
      margin-bottom: 10px;
    }

    .form-control {
      border-radius: 5px !important;
    }
        .register-box button {
            width: 100%;
            padding: 10px;
            background: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .register-box button:hover {
            background: #0056b3;
        }

        .register-box a {
            display: block;
            margin-top: 15px;
            
            color: #007bff;
            text-decoration: none;
        }

        .register-box a:hover {
            text-decoration: underline;
        }
        
                .password-wrapper {
                position: relative;
                }

                .password-wrapper input {
                width: 100%;
                padding-right: 10px; /* leave space for the button */
                }

                .password-wrapper button {
                    width: 80px;
                    height: 30px;
                position: absolute;
                right: -80px;
                top: 13%;
                transform: translateY(-10%);
                background: #007bff;
                color: #fff;
                border: none;
                border-radius: 10px;
                cursor: pointer;
                }
        .trimexlogo a
         {
            text-decoration: none;
            color: black;
           
            padding: 6px 12px;
            border-radius: 4px;
            transition: background-color 0.2s ease;
            }
/* === Scoped Login Dropdown === */
    .navbar .auth-links {
      position: relative;
    }

    .navbar .auth-links .login-dropdown {
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

    .navbar .auth-links .login-dropdown input {
     width: 90%;
      padding: 8px;
      margin: 6px 0;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 14px;
    }

    .navbar .auth-links .login-dropdown button[type="submit"] {
      width: 100%;
      padding: 8px;
      border: none;
      background-color: red;
      color: white;
      border-radius: 5px;
      cursor: pointer;
      font-size: 15px;
    }

    .navbar .auth-links .login-dropdown button[type="submit"]:hover {
      background-color: darkred;
    }

    /* === Scoped Password Toggle === */
    .navbar .auth-links .login-dropdown .password-wrapper {
      position: relative;
    }

    .navbar .auth-links .login-dropdown .password-wrapper input {
      width: 100%;
      padding-right: 35px; /* space for eye icon */
    }

    .navbar .auth-links .login-dropdown .toggle-password-btn {
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

    .navbar .auth-links .login-dropdown .toggle-password-btn:hover {
      color: #000;
    }
     .navbar .auth-links .password-wrappers {
      position: relative;
    }

     .navbar .auth-links .password-wrappers input {
      width: 80%;
      padding-right: 35px; /* space for the icon */
    }

     .navbar .auth-links .toggle-password-btn {
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

     .navbar .auth-links .toggle-password-btn:hover {
      color: #000;
    }



    </style>
   <!-- Load YOUR styles AFTER -->
<link rel="stylesheet" href="style/hmmenu.css">
</head>
<body>
   <div class="navbar">
  <div class="trimexlogo">
  
  </div>
  <div class="auth-links">
    <a href="#" id="loginBtn" class="login">Log in</a>
    <a href="Signup.php" class="signup">Sign up</a>

    <!-- Dropdown Login -->
    <div id="loginBox" class="login-dropdown">
      <form action="api/login_process.php" method="POST">
        <input type="text" name="username" placeholder="Username" required>

        <div class="password-wrappers">
          <input type="password" id="password1" name="password" placeholder="Password" required />
          <button type="button" id="togglePassword1" class="toggle-password-btn">
            <i class="fa-solid fa-eye"></i>
          </button>
        </div>

        <button type="submit">Login</button>
      </form>
    </div>
  </div>
</div>
  <div class="register-box">
    <h2>Register</h2>

    <form action="api/Register_process.php" method="POST">
      <div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
        <input type="text" name="first_name" class="form-control" placeholder="First Name" required />
      </div>

      <div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
        <input type="text" name="last_name" class="form-control" placeholder="Last Name" required />
      </div>

      <div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
        <input type="text" name="username" class="form-control" placeholder="Username" required />
      </div>

     <div class="input-group password-wrapper">
      <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
      <input type="password" id="password2" name="password" class="form-control" placeholder="Password" required />
      <button type="button" id="togglePassword2" class="toggle-password-btn">
        <i class="glyphicon glyphicon-eye-open"></i>
  </button>
</div>

      <button type="submit">Register</button>
    </form>
  </div>

<script src="src/toggle-password.js"></script>
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
    document.getElementById('togglePassword1').addEventListener('click', function() {
    const passwordInput = document.getElementById('password1');
    const icon = this.querySelector('i');
    const isPassword = passwordInput.getAttribute('type') === 'password';
    passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
    icon.classList.toggle('fa-eye');
    icon.classList.toggle('fa-eye-slash');
  });
</script>
</body>
</html>