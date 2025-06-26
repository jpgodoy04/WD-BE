<?php
session_start();
require 'config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = trim($_POST['username'] ?? '');
    $pass = $_POST['password'] ?? '';

    $stmt = $pdo->prepare('SELECT id, username, password FROM users WHERE username = ?');
    $stmt->execute([$user]);
    $row = $stmt->fetch();

  /* after you have $row and the plain-text password matches … */
if ($row && $pass === $row['password']) {

    $_SESSION['user_id']  = $row['id'];
    $_SESSION['username'] = $row['username'];

    /* determine the role on the fly */
    $_SESSION['role'] = ($row['username'] === 'admin') ? 'admin' : 'user';

    /* redirect */
    header('Location: ' . ($_SESSION['role'] === 'admin' ? 'admin.php' : 'index.php'));
    exit;
}

    $error = 'Invalid username or password';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login – Beyond the Brush</title>

  <!-- Bootstrap & fonts -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@700&display=swap" rel="stylesheet">

  <style>
    /* backdrop */
    html,body{height:100%;margin:0}
    body{
      background:url('img/bg-art.jpg') center/cover fixed #000 no-repeat;
      display:flex;justify-content:center;align-items:center;font-family:Georgia,serif;color:#000;
    }
    /* frosted glass card */
    .card-login{width:320px;min-height:350px;padding:2.5rem 2rem;background:rgba(255,255,255,.25);
      border-radius:15px;border:1px solid rgba(255,255,255,.55);backdrop-filter:blur(8px);box-shadow:0 0 10px rgba(0,0,0,.4);position:relative}
    .card-login:before{content:'';width:10px;height:10px;border-radius:50%;background:#4d596a;position:absolute;top:18px;left:18px}
    h2{font-family:'Cinzel',serif;letter-spacing:3px;text-transform:uppercase;font-size:1.3rem;margin-bottom:2rem;text-align:center}
    label{font-size:.75rem;margin-bottom:.25rem}
    .form-control{border-radius:25px;background:rgba(255,255,255,.6);border:1px solid #c9c9c9}
    .btn-primary{background:#1a1a4d;border:none;border-radius:30px;font-size:.8rem;letter-spacing:.5px;padding:.45rem 2rem}
    .error-msg{color:#d9534f;font-size:.85rem;margin-top:1rem;text-align:center}
  </style>
</head>
<body>

  <div class="card-login">
    <h2>Login</h2>

    <?php if ($error): ?>
      <div class="error-msg"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post" class="mt-3">
      <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input id="username" name="username" class="form-control" required>
      </div>

      <div class="mb-4">
        <label for="password" class="form-label">Password</label>
        <input id="password" type="password" name="password" class="form-control" required>
      </div>

      <div class="text-center">
        <button type="submit" class="btn btn-primary">Login</button>
      </div>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
