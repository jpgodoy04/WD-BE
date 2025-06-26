<?php
require 'config.php';
$pageTitle = 'BEYOND THE BRUSH';

$logoPath = $pdo->query("SELECT imagePath FROM paintings WHERE title = 'navbar' LIMIT 1")->fetchColumn();
$paintings = $pdo->query("SELECT id,title,imagePath FROM paintings WHERE title NOT IN ('navbar','painting') ORDER BY id")->fetchAll();

include 'navbar.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Paintings – Beyond the Brush</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@700&display=swap" rel="stylesheet" />
  <style>
    body {
      background: url('img/bg-blue.jpg') center/cover fixed #021a3e;
      margin: 0;
      color: #fff;
      font-family: Georgia, serif;
      padding-top: 72px;
      min-height: 100vh;
      overflow-x: hidden;
    }

    .blue-underline {
      height: 4px;
      width: 100%;
      background: #0d6efd;
      position: fixed;
      top: 56px;
      left: 0;
      z-index: 1000;
    }

    h1.page-title {
      font-family: 'Cinzel', serif;
      letter-spacing: 2px;
      text-transform: uppercase;
      font-size: 2rem;
      text-align: center;
      margin: 1.75rem 0 1.5rem;
    }

    .grid-wrapper {
      max-width: 1150px;
      margin: 0 auto;
      padding: 0 15px;
    }

    .painting-card {
      background: #fff;
      border: 2px solid #fff;
      border-radius: 8px;
      overflow: hidden;
      transition: transform 0.2s;
      width: 100%;
    }

    .painting-card:hover {
      transform: translateY(-4px);
    }

    .painting-img {
      width: 100%;
      height: 160px;
      object-fit: cover;
    }

    .painting-title {
      font-size: 1rem;
      font-weight: 600;
      color: #000;
      margin: 0.85rem 0;
      white-space: normal;
      text-align: center;
    }

    .btn-view {
      border: 1px solid #d0d0d0;
      font-size: 0.76rem;
      padding: 4px 24px;
      border-radius: 30px;
      background: #fff;
      color: #000;
    }
  </style>
</head>
<body>
  <div class="blue-underline"></div>

  <div class="grid-wrapper text-center">
    <h1 class="page-title">Paintings</h1>
    <div class="row g-4 justify-content-center">
      <?php foreach ($paintings as $p): ?>
        <div class="col-12 col-md-4 d-flex">
          <div class="painting-card d-flex flex-column align-items-center w-100">
            <img src="<?= htmlspecialchars($p['imagePath']) ?>" alt="<?= htmlspecialchars($p['title']) ?>" class="painting-img" />
            <div class="painting-title px-2" title="<?= htmlspecialchars($p['title']) ?>">
              <?= htmlspecialchars($p['title']) ?>
            </div>
            <a href="painting.php?id=<?= $p['id'] ?>" class="btn btn-view mb-3">VIEW</a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- ABOUT SECTION -->
  <section id="about" style="display:none;position:relative;padding:70px 20px;background:rgba(0,0,0,0.7);color:white;margin-top:40px;text-align:center">
    <button class="close-btn" onclick="hideAbout()" style="position:absolute;top:10px;right:20px;background:none;border:none;color:white;font-size:2rem;cursor:pointer">×</button>
    <div class="container max-width-800">
      <h2>About This Project</h2>
      <p>This website shows examples of Filipino historical and cultural artworks. Thank you for visiting!</p>
    </div>
  </section>

  <!-- HELP SECTION -->
  <section id="help" style="display:none;position:relative;padding:70px 20px;background:rgba(0,0,0,0.7);color:white;margin-top:40px;text-align:center">
    <button class="close-btn" onclick="hideHelp()" style="position:absolute;top:10px;right:20px;background:none;border:none;color:white;font-size:2rem;cursor:pointer">×</button>
    <div class="container max-width-800">
      <h2>Help Section</h2>
      <p>Here's how to use:</p>
      <ul style="list-style:none;padding-left:0">
        <li>• Click on the paintings to view their details.</li>
        <li>• Use the nav bar to explore or return to the homepage.</li>
        <li>• If something doesn't work, try refreshing the page.</li>
      </ul>
    </div>
  </section>

  <script>
    function goHome() {
      document.getElementById("about").style.display = "none";
      document.getElementById("help").style.display = "none";
      window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function showAbout() {
      document.getElementById("about").style.display = "block";
      document.getElementById("help").style.display = "none";
      document.getElementById("about").scrollIntoView({ behavior: "smooth" });
    }

    function hideAbout() {
      document.getElementById("about").style.display = "none";
    }

    function showHelp() {
      document.getElementById("help").style.display = "block";
      document.getElementById("about").style.display = "none";
      document.getElementById("help").scrollIntoView({ behavior: "smooth" });
    }

    function hideHelp() {
      document.getElementById("help").style.display = "none";
    }
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
