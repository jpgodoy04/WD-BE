<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}
?>

<?php
require 'config.php';

if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    header('Location: login.php');
    exit;
}

$page = $_GET['page'] ?? 'dashboard';
$users = ($page === 'users') ? $pdo->query('SELECT id, username FROM users ORDER BY id')->fetchAll() : [];
$paintings = ($page === 'paintings') ? $pdo->query('SELECT id, title, artist FROM paintings WHERE title NOT IN ("navbar", "painting") ORDER BY id')->fetchAll() : [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Admin – Beyond the Brush</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    html, body { height: 100%; margin: 0; }
    body { display: flex; font-family: system-ui, Arial, sans-serif; }
    .sidebar {
      width: 260px; background: #0b1a2d; color: #fff;
      display: flex; flex-direction: column; padding: 2rem 1rem 1rem;
    }
    .sidebar h3 { font-size: 1.35rem; margin-bottom: 2rem; }
    .nav-link {
      color: #fff; display: flex; align-items: center; gap: .6rem;
      padding: .55rem .9rem; border-radius: 6px; text-decoration: none;
    }
    .nav-link:hover { background: #112446; color: #fff; }
    .nav-link.active { background: #112446; }

    .content { flex: 1; display: flex; flex-direction: column; background: #f3f4f6; }
    .topbar {
      height: 56px; background: #fff;
      display: flex; justify-content: flex-end; align-items: center;
      padding: 0 1rem; box-shadow: 0 1px 2px rgba(0,0,0,.06);
    }
    .btn-logout {
      border: 1px solid #ccc; border-radius: 6px;
      padding: .35rem 1.2rem; font-size: .9rem; background: #fff; color: #333;
      text-decoration: none;
    }

    .main { flex: 1; overflow-y: auto; padding: 2rem; }

    .welcome-card {
      background: #fff; border-radius: 12px;
      box-shadow: 0 10px 25px rgba(0,0,0,.08);
      max-width: 950px; margin: 0 auto; padding: 3rem; text-align: center;
    }

    table {
      background: #fff; border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0,0,0,.05);
    }
    th, td { padding: .65rem 1rem; }
  </style>
</head>
<body>

  <aside class="sidebar">
    <h3>Beyond The Brush</h3>
    <a class="nav-link <?= $page === 'dashboard' ? 'active' : '' ?>" href="admin.php?page=dashboard">Dashboard</a>
    <a class="nav-link <?= $page === 'paintings' ? 'active' : '' ?>" href="admin.php?page=paintings">Manage Paintings</a>
    <a class="nav-link <?= $page === 'users' ? 'active' : '' ?>" href="admin.php?page=users">Users</a>
    <a class="nav-link" href="logout.php">Logout</a>
  </aside>

  <section class="content">
    <div class="topbar">
      <a href="logout.php" class="btn btn-logout">Logout</a>
    </div>

    <div class="main">
      <?php if ($page === 'dashboard'): ?>
        <div class="welcome-card">
          <h1>Welcome, Admin</h1>
          <p class="lead">Manage your gallery, users, and everything in between — all in one place.</p>
          <hr />
          <p>Beyond the Brush empowers you to celebrate Filipino culture through powerful artworks. Dive in and keep the stories alive!</p>
        </div>

      <?php elseif ($page === 'users'): ?>
        <h2 class="mb-4">User Accounts</h2>
        <table class="table table-striped">
          <thead class="table-dark">
            <tr><th>ID</th><th>Username</th></tr>
          </thead>
          <tbody>
            <?php foreach ($users as $u): ?>
              <tr><td><?= $u['id'] ?></td><td><?= htmlspecialchars($u['username']) ?></td></tr>
            <?php endforeach; ?>
          </tbody>
        </table>

      <?php elseif ($page === 'paintings'): ?>
        <h2 class="mb-4">Paintings</h2>
        <table class="table table-striped">
          <thead class="table-dark">
            <tr><th>ID</th><th>Title</th><th>Artist</th></tr>
          </thead>
          <tbody>
            <?php foreach ($paintings as $p): ?>
              <tr>
                <td><?= $p['id'] ?></td>
                <td><?= htmlspecialchars($p['title']) ?></td>
                <td><?= htmlspecialchars($p['artist']) ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php endif; ?>
    </div>
  </section>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
