<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>T-Tracks</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="style/hmmenu.css"> 
    <style>
        
        .Login-box {
            background: #ffffff;
            padding: 80px 50px;
            width: 400px;
            text-align: center;
            margin: 0 auto; /* horizontally center */
            
           
        }

        .Login-box h2 {
            margin-bottom: 20px;
            color: #333;
        }

        .Login-box input,
        .Login-box select {
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
        .Login-box button {
            width: 100%;
            padding: 10px;
            background: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .Login-box button:hover {
            background: #0056b3;
        }

        .Login-box a {
            display: block;
            margin-top: 15px;
            
            color: #007bff;
            text-decoration: none;
        }

        .Login-box a:hover {
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
                top: 10%;
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
</head>
<body>

    <div class="navbar">
  <div class="trimexlogo">
    <a href="homescreen.php">
    CAPSTONE TRACKER
    </a>
  </div>
  <div class="auth-links">
     <a href="Login.php" class="login">Log in</a>
    <a href="Signup.php" class="signup">Sign up</a>
  </div>
</div>
 <div class="Login-box">
    <h2>Log in</h2>

    <form action="api/login_process.php" method="POST">
      
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

      <button type="submit">Login</button>
      <a href="login.php">Already have an account?</a>
    </form>
  </div>
    
<script src="src/toggle-password.js"></script>
</script>
</body>
</html>