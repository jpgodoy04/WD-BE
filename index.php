<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}
?>
<?php
require 'config.php';
$pageTitle = 'Beyond the Brush';

// fetch optional logo row (title = 'navbar')
$logoStmt = $pdo->prepare('SELECT imagePath FROM paintings WHERE title = ? LIMIT 1');
$logoStmt->execute(['navbar']);
$logoPath = $logoStmt->fetchColumn();

// fetch a thumbnail to use for the "Paintings" category card
$categoryStmt = $pdo->prepare('SELECT imagePath FROM paintings WHERE title = ? LIMIT 1');
$categoryStmt->execute(['painting']);   // make sure you have this row in the DB
$categoryImg = $categoryStmt->fetchColumn();

// include shared navbar (expects $pageTitle & optional $logoPath)
include 'navbar.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= htmlspecialchars($pageTitle) ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Risque&display=swap" rel="stylesheet">
  <style>

    html{scroll-behavior:smooth}
    body{background:url('img/bg-art.jpg') center/cover fixed;font-family:Georgia,serif;margin:0;padding:0;color:#fff;min-height:100vh;display:flex;flex-direction:column}

    .navbar{background-color:#000;border-bottom:4px solid #0d6efd}
    .navbar-nav .nav-link{color:#fff;font-weight:500;margin-left:20px;cursor:pointer}

    .container-content{padding-top:100px;flex:1}
    h1{font-family:'Risque',serif;font-size:3.5rem;font-weight:700;letter-spacing:2px;text-shadow:2px 2px 4px rgba(0,0,0,.6);text-transform:uppercase}
    p{font-size:1.1rem;margin-bottom:25px}

    .btn-custom{background:#4e4035;border:none;padding:10px 22px;font-size:1rem;color:#fff;border-radius:10px}
    .btn-custom:hover{background:#6b5649}

    .category-card{background:rgba(255,255,255,.1);padding:20px;border-radius:15px;transition:transform .3s ease;border:2px solid #fff;max-width:300px;width:100%}
    .category-card:hover{transform:scale(1.03)}
    .category-card img{width:100%;border-radius:10px}
    .category-card h5{color:#fff;font-size:1.2rem;margin-top:15px}

    #about,#help{display:none;position:relative;padding:70px 20px;background:rgba(0,0,0,.7);color:#fff;margin-top:40px;text-align:center}
    .close-btn{position:absolute;top:10px;right:20px;background:none;border:none;color:#fff;font-size:2rem;cursor:pointer}
    .close-btn:hover{color:red}
    #help ul{list-style:none;padding-left:0}
    #help ul li::before{content:'• ';color:#f8c291}
    .background: url('img/bg-home.jpg') no-repeat center center fixed;
background-size: cover;

  </style>
</head>
<body>
  <!-- HERO SECTION -->
  <div class="container container-content d-flex flex-column align-items-center justify-content-center text-center" id="home-section">
    <div>
      <h1>SIMPLY ART. SIMPLY BEAUTIFUL</h1>
      <p>"Seventeen years of colors, stories, and inspiration. Start your art journey today."</p>
    </div>
    <div class="d-grid gap-3 col-8 col-md-6 mt-3">
      <a href="#categories-section" class="btn btn-custom">Filipino Historical &amp; Cultural Artworks</a>
    </div>
  </div>

  <!-- CATEGORIES SECTION -->
  <section id="categories-section" style="margin-top:80px" class="d-flex flex-column align-items-center justify-content-center text-center py-5">
    <h2 class="mb-4" style="color:#fff;font-size:2rem">Categories</h2>
    <a href="gallery.php" class="text-decoration-none">
      <div class="category-card">
        <img src="<?= htmlspecialchars($categoryImg ?: 'img/Paintings.jpg') ?>" alt="Paintings">
        <h5>Paintings</h5>
      </div>
    </a>
  </section>

  <!-- ABOUT -->
  <section id="about">
    <button class="close-btn" onclick="hideAbout()">×</button>
    <div class="container max-width-800">
      <h2>About This Project</h2>
      <p>This website shows examples of Filipino historical and cultural artworks. Thank you for visiting!</p>
      <a href="login.php" class="btn btn-custom mt-3">Go to Admin</a>
    </div>
  </section>

  <!-- HELP -->
  <section id="help">
    <button class="close-btn" onclick="hideHelp()">×</button>
    <div class="container max-width-800">
      <h2>Help Section</h2>
      <p>Here's how to use:</p>
      <ul>
        <li>Click on the categories to view more artworks.</li>
        <li>Use the nav bar to explore or go back to the homepage.</li>
        <li>If something doesn't work, try refreshing the page.</li>
      </ul>
    </div>
  </section>

  <script>
    function goHome(){document.getElementById('about').style.display='none';document.getElementById('help').style.display='none';document.getElementById('home-section').scrollIntoView({behavior:'smooth'});}    
    function showAbout(){document.getElementById('about').style.display='block';document.getElementById('help').style.display='none';document.getElementById('about').scrollIntoView({behavior:'smooth'});} 
    function hideAbout(){document.getElementById('about').style.display='none';}
    function showHelp(){document.getElementById('help').style.display='block';document.getElementById('about').style.display='none';document.getElementById('help').scrollIntoView({behavior:'smooth'});} 
    function hideHelp(){document.getElementById('help').style.display='none';}
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
