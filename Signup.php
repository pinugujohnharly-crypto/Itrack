<?php
  $page_title = 'I‑Tracks | Sign up';
  $is_home = false;
  $hero_title = 'Create Account';
  $hero_subtitle = 'Join to track and manage capstone projects';
  include 'includes/header.php';
  include 'includes/navbar.php';
  include 'includes/hero.php';
?>

<section class="py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8 col-lg-6">
        <div class="card shadow-sm border-0">
          <div class="card-body p-4">
            <h2 class="h4 fw-bold mb-4">Register</h2>
            <form action="api/Register_process.php" method="POST">
              <div class="mb-3">
                <label for="first_name" class="form-label">First Name</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fa-regular fa-user"></i></span>
                  <input type="text" id="first_name" name="first_name" class="form-control" placeholder="First Name" required />
                </div>
              </div>

              <div class="mb-3">
                <label for="last_name" class="form-label">Last Name</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fa-regular fa-user"></i></span>
                  <input type="text" id="last_name" name="last_name" class="form-control" placeholder="Last Name" required />
                </div>
              </div>

              <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fa-regular fa-envelope"></i></span>
                  <input type="text" id="username" name="username" class="form-control" placeholder="Username" required />
                </div>
              </div>

              <div class="mb-3">
                <label for="signup-password" class="form-label">Password</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                  <input type="password" id="signup-password" name="password" class="form-control" placeholder="Password" required />
                  <button type="button" id="signup-togglePassword" class="btn btn-outline-secondary" aria-label="Toggle password visibility">
                    <i class="fa-solid fa-eye"></i>
                  </button>
                </div>
              </div>

              <div class="d-grid">
                <button type="submit" class="btn btn-accent">Register</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  
</section>

<?php include 'includes/footer.php'; ?>

