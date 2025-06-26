<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
  <div class="container-fluid">
    <a href="index.php" class="navbar-brand d-flex align-items-center gap-2">
      <?php if (!empty($logoPath)): ?>
        <img src="<?= htmlspecialchars($logoPath) ?>" alt="Logo" height="28" class="rounded-1">
      <?php endif; ?>
      <span><?= htmlspecialchars($pageTitle ?? 'Beyond the Brush') ?></span>
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link" onclick="goHome()">Home</a></li>
        <li class="nav-item"><a class="nav-link" onclick="showHelp()">Help</a></li>
        <li class="nav-item"><a class="nav-link" onclick="showAbout()">About</a></li>
        <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li> <!-- ✅ ADDED -->
      </ul>
    </div>
  </div>
</nav>
