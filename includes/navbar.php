<?php
// Shared Bootstrap navbar
// Optional: set $is_home = true on home page to keep in-page anchors
?>
<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom sticky-top">
  <div class="container">
    <a class="navbar-brand fw-bold" href="Homescreen.php">
      <i class="fa-solid fa-layer-group me-2 brand-accent"></i>CAPSTONE TRACKER
    </a>
    <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="mainNav">
      <ul class="navbar-nav ms-auto align-items-lg-center">
        <?php
          $aboutHref = (isset($is_home) && $is_home) ? '#about' : 'Homescreen.php#about';
          $objHref = (isset($is_home) && $is_home) ? '#objectives' : 'Homescreen.php#objectives';
        ?>
        <li class="nav-item"><a class="nav-link" href="<?php echo $aboutHref; ?>">About</a></li>
        <li class="nav-item"><a class="nav-link" href="<?php echo $objHref; ?>">Objectives</a></li>
        <li class="nav-item me-lg-2 mt-2 mt-lg-0">
          <a class="btn btn-outline-secondary" href="Signup.php">Sign up</a>
        </li>
        <li class="nav-item mt-2 mt-lg-0">
          <button class="btn btn-accent" data-bs-toggle="modal" data-bs-target="#loginModal">Log in</button>
        </li>
      </ul>
    </div>
  </div>
</nav>

