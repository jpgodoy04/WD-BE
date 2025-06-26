<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}
?>

<?php
require 'config.php';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if($id<=0){http_response_code(400);exit('Invalid painting id');}
$paintingStmt=$pdo->prepare('SELECT * FROM paintings WHERE id=?');
$paintingStmt->execute([$id]);
$painting=$paintingStmt->fetch();
if(!$painting){http_response_code(404);exit('Painting not found');}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= htmlspecialchars($painting['title']) ?> – Beyond the Brush</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body,html{height:100%;margin:0}
    body{background:url('img/b.jpg') center/cover fixed,#000 no-repeat;font-family:'Georgia',serif;color:#fff;display:flex;flex-direction:column}
    .overlay{flex:1;display:flex;justify-content:center;align-items:center;padding:6rem 1rem}
    .frame{background:linear-gradient(180deg,#121212,#000);padding:2rem;border-radius:6px;max-width:900px;width:100%;text-align:center;box-shadow:0 0 12px rgba(0,0,0,.6)}
    .painting-img{width:100%;max-height:520px;object-fit:contain;border:20px solid #7d5235;border-image: url('img/frame-texture.png') 30 round; /* fancy frame effect */}
    .desc{font-family:system-ui,Arial,sans-serif;font-size:.9rem;margin-top:1rem;line-height:1.6}
  </style>
</head>
<body>
  <!-- Simple back nav -->
  <nav class="navbar navbar-dark bg-dark fixed-top shadow-sm">
    <div class="container-fluid"><a class="navbar-brand fw-bold" href="gallery.php">&larr; Back to Gallery</a></div>
  </nav>

  <div class="overlay mt-5 pt-4">
    <div class="frame">
      <h1 class="h4 fw-bold mb-3"><?= htmlspecialchars($painting['title']) ?></h1>
      <img src="<?= htmlspecialchars($painting['imagePath']) ?>" class="painting-img mb-3" alt="<?= htmlspecialchars($painting['title']) ?>">
      <p class="desc mb-4"><?= nl2br(htmlspecialchars($painting['description'])) ?></p>
      <a href="gallery.php" class="btn btn-light btn-sm">&larr; Back to Gallery</a>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>