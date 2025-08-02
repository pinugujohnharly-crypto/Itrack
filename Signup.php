<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>T-Tracks</title>
<!-- Load Bootstrap FIRST -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">




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

    </style>
   <!-- Load YOUR styles AFTER -->
<link rel="stylesheet" href="style/hmmenu.css">
</head>
<body>
   <div class="navbar">
  <div class="trimexlogo">
    <a href="homescreen.php">
      <img src="logo/Trimex.jpg" alt="Trimex Logo" style="height: 40px; vertical-align: middle;">
      TRIMEX CAPSTONE TRACKER
    </a>
  </div>
  <div class="auth-links">
    <a href="Login.php" class="login">Log in</a>
    <a href="Signup.php" class="signup">Sign up</a>
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
      <input type="password" id="password" name="password" class="form-control" placeholder="Password" required />
      <button type="button" id="togglePassword" class="toggle-password-btn">
        <i class="glyphicon glyphicon-eye-open"></i>
  </button>
</div>

      <button type="submit">Register</button>
      <a href="login.php">Already have an account? Login</a>
    </form>
  </div>

<script src="src/toggle-password.js"></script>

</body>
</html>