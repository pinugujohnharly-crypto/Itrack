<?php
// Shared hero section
// Usage:
//   - Home page: set $hero_page = 'home'
//   - Other pages: set $hero_title = 'Page Title'
?>
<?php if (isset($hero_page) && $hero_page === 'home'): ?>
  <header class="py-5 hero-bg">
    <div class="container py-4">
      <div class="row align-items-center g-4">
        <div class="col-lg-7">
          <h1 class="display-5 fw-bold mb-3">I‑Tracks</h1>
          <p class="lead text-secondary mb-4">Interactive platform for tracking capstone proposals, milestones, reviews, and final outputs across the College of Computer Studies.</p>
          <div class="d-flex gap-2">
            <button class="btn btn-accent btn-lg" data-bs-toggle="modal" data-bs-target="#loginModal">
              <i class="fa-solid fa-right-to-bracket me-2"></i>Log in
            </button>
            <a class="btn btn-outline-secondary btn-lg" href="Signup.php">
              <i class="fa-solid fa-user-plus me-2"></i>Create account
            </a>
          </div>
        </div>
        <div class="col-lg-5">
          <div class="card shadow-sm border-0">
            <div class="card-body p-4">
              <h5 class="card-title mb-3">Capstone Project Platform</h5>
              <p class="mb-2">A capstone project by</p>
              <ul class="list-unstyled small mb-0">
                <li class="mb-1"><i class="fa-regular fa-user me-2 text-secondary"></i>Kyle Austin Nagares</li>
                <li class="mb-1"><i class="fa-regular fa-user me-2 text-secondary"></i>John Harly Pinugu</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>
<?php elseif (isset($hero_title)): ?>
  <header class="py-5 hero-bg">
    <div class="container py-4">
      <div class="row justify-content-center">
        <div class="col-lg-8 text-center">
          <h1 class="display-6 fw-bold mb-2"><?php echo htmlspecialchars($hero_title); ?></h1>
          <?php if (!empty($hero_subtitle)): ?>
            <p class="lead text-secondary mb-0"><?php echo htmlspecialchars($hero_subtitle); ?></p>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </header>
<?php endif; ?>

