<?php
// Shared header: doctype, head, CSS, and opening body
// Usage: set $page_title (optional) before including
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?php echo isset($page_title) ? htmlspecialchars($page_title) : 'CAPSTONE TRACKER'; ?></title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome (for icons) -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
  <!-- Site styles -->
  <link rel="stylesheet" href="style/hmmenu.css" />

  <style>
    :root { --accent:#e11d48; }
    html, body { max-width: 100%; overflow-x: hidden; }
    /* Normalize navbar styles across pages (override hmmenu.css where needed) */
    .navbar {
      padding: .5rem 1rem;
      background-color: #fff;
      border-bottom: 1px solid #dee2e6;
      font-size: 1rem;
    }
    .navbar .navbar-toggler {
      margin-left: auto;
      min-width: 44px;
      min-height: 44px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
    }
    .navbar .navbar-brand {
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
      min-width: 0;
    }
    @media (max-width: 430px) {
      .navbar { padding: .5rem .75rem; }
      .navbar .navbar-brand { font-size: 1rem; }
      .navbar .navbar-collapse { padding-top: .25rem; }
      .navbar .nav-link { padding: .75rem .5rem; }
    }
    /* Shared helpers */
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

