<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>I‑Tracks | Capstone Tracker</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome (for icons) -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
  <!-- Keep existing styles if needed elsewhere -->
  <link rel="stylesheet" href="style/hmmenu.css" />

  <style>
    :root { --accent:#e11d48; }
    /* Override broad rules from style/hmmenu.css on this page
       to keep Bootstrap's navbar layout intact on small screens */
    .navbar {
      padding: .5rem 1rem;              /* prevent wrapping at small widths */
      background-color: #fff;            /* match bg-white class */
      border-bottom: 1px solid #dee2e6;  /* match border-bottom class */
      font-size: 1rem;                   /* neutralize hmmenu.css x-large */
    }
    .navbar .navbar-toggler {            /* make tap target ≥44px */
      margin-left: auto;
      min-width: 44px;
      min-height: 44px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
    }
    .navbar .navbar-brand {              /* avoid odd wrapping */
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }
    @media (max-width: 430px) {
      .navbar { padding: .5rem .75rem; }
      .navbar .navbar-brand { font-size: 1rem; }
      .navbar .navbar-collapse { padding-top: .25rem; }
      .navbar .nav-link { padding: .75rem .5rem; }
    }
    .hero-bg {
      background:
        radial-gradient(40rem 40rem at 110% -10%, rgba(225,29,72,.06), transparent 40%),
        radial-gradient(36rem 36rem at -10% -10%, rgba(14,165,233,.06), transparent 40%);
    }
    .brand-accent { color: var(--accent) !important; }
    .btn-accent { background: var(--accent); color:#fff; }
    .btn-accent:hover { filter:brightness(.95); color:#fff; }
  </style>
</head>
<body class="bg-white text-dark">
  <!-- Navbar -->
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
          <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
          <li class="nav-item"><a class="nav-link" href="#objectives">Objectives</a></li>
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

  <!-- Hero -->
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

  <!-- About / Context -->
  <section id="about" class="py-5">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-10">
          <h2 class="h3 fw-bold mb-3">Project Context</h2>
          <p class="text-secondary mb-4">
            The main goal of the College of Computer Studies’ Interactive Digital Platform for Tracking Capstone Projects is to make it easier for students, teachers, and staff to keep track of capstone projects and how far along each one is. More specifically, the platform aims to create one system where everyone involved can easily manage and follow each project’s progress. It also helps make the process of submitting project ideas and final outputs more organized and smoother, reducing confusion or delays. Lastly, it gives faculty advisers better tools to monitor student progress, provide feedback, and approve work, making it easier for them to guide students through their capstone journey.
          </p>

          <div class="row g-3">
            <div class="col-md-4">
              <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                  <div class="d-flex align-items-center mb-2">
                    <i class="fa-solid fa-diagram-project me-2 text-primary"></i>
                    <h3 class="h6 mb-0">Centralized Tracking</h3>
                  </div>
                  <p class="small text-secondary mb-0">Organize projects, proposals, milestones, and final outputs in one place.</p>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                  <div class="d-flex align-items-center mb-2">
                    <i class="fa-solid fa-paper-plane me-2 text-success"></i>
                    <h3 class="h6 mb-0">Streamlined Submissions</h3>
                  </div>
                  <p class="small text-secondary mb-0">Reduce delays with a clear flow for idea proposals and approvals.</p>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                  <div class="d-flex align-items-center mb-2">
                    <i class="fa-solid fa-user-check me-2 text-warning"></i>
                    <h3 class="h6 mb-0">Adviser Tools</h3>
                  </div>
                  <p class="small text-secondary mb-0">Monitor progress, provide feedback, and approve work efficiently.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Objectives -->
  <section id="objectives" class="py-5 bg-light">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-10">
          <div class="row g-4 align-items-stretch">
            <div class="col-md-5">
              <div class="p-4 bg-white border rounded-3 h-100">
                <h2 class="h4 fw-bold mb-2">General Objective</h2>
                <p class="mb-0 text-secondary">Create an uncomplicated platform enabling students, staff, and teachers to track capstone projects for each project.</p>
              </div>
            </div>
            <div class="col-md-7">
              <div class="p-4 bg-white border rounded-3 h-100">
                <h3 class="h5 fw-bold mb-3">Specific Objectives</h3>
                <ul class="mb-0 text-secondary">
                  <li class="mb-2">Develop a centralized system that allows students and faculty to efficiently organize, track, and manage capstone projects.</li>
                  <li class="mb-2">Provide a systematic procedure for project ideas and final submissions to improve the submission and approval process.</li>
                  <li class="mb-2">Create better monitoring and collaboration through simpler tools for advisers to analyze, advise on, and approve capstone work.</li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="py-4 border-top bg-white">
    <div class="container d-flex flex-wrap justify-content-between align-items-center">
      <span class="text-secondary small">© <span id="y"></span> I‑Tracks • College of Computer Studies</span>
    </div>
  </footer>

  <!-- Login Modal -->
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
    document.getElementById('y').textContent = new Date().getFullYear();
    // Password visibility toggle
    const togglePasswordBtn = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('login-password');
    if (togglePasswordBtn && passwordInput) {
      togglePasswordBtn.addEventListener('click', function () {
        const isPassword = passwordInput.getAttribute('type') === 'password';
        passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
        const icon = this.querySelector('i');
        icon.classList.toggle('fa-eye');
        icon.classList.toggle('fa-eye-slash');
      });
    }
  </script>
</body>
</html>
