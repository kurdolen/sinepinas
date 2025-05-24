<!-- Load necessary functions -->
<?php
include 'functions/load_database.php';
loadDatabase();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./vars.css">
  <link rel="stylesheet" href="./style.css">
  <link rel="stylesheet" href="./index.css">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600&display=swap" rel="stylesheet">

  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
  <script src="JS/script.js"></script>

  <title>SinePinas</title>
</head>
<body>
 
  <div class="index-bg">
    <div class="index-main">
        <h1>SinePinas</h1>

        <div class="description">
          <p>
            Discover the heart of Filipino cinema. Stream a wide collection of classic and contemporary Filipino movies—anytime, anywhere. From timeless dramas to modern indie hits, experience stories that celebrate Filipino culture, passion, and pride.
          </p>
        </div>

        <div class="explore">
          <a href="home.php">
            <h2>Explore Movies</h2>
          </a>
        </div>
  </div>
    
  <footer class="footer">
    <div class="footer-content">
      <div class="footer-section">
        <h3>SinePinas</h3>
        <p>Your destination for Filipino cinema. Discover classic Filipino films.</p>
      </div>

      <div class="footer-section">
        <h4>Navigate</h4>
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="home.php">Explore Movies</a></li>
        </ul>
      </div>

      <div class="footer-section">
        <h4>Categories</h4>
        <ul>
          <li><a href="#">Drama</a></li>
          <li><a href="#">Romance</a></li>
          <li><a href="#">Comedy</a></li>
          <li><a href="#">Horror</a></li>
          <li><a href="#">Action</a></li>
        </ul>
      </div>

      <div class="footer-section">
        <h4>Connect With Us</h4>
        <div class="social-links">
          <a href="#" aria-label="Facebook"><ion-icon name="logo-facebook"></ion-icon></a>
          <a href="#" aria-label="Twitter"><ion-icon name="logo-twitter"></ion-icon></a>
          <a href="#" aria-label="Instagram"><ion-icon name="logo-instagram"></ion-icon></a>
          <a href="#" aria-label="YouTube"><ion-icon name="logo-youtube"></ion-icon></a>
        </div>
      </div>
    </div>

    <div class="footer-bottom">
      <p>&copy; 2024 SinePinas. All rights reserved.</p>
    </div>
  </footer>
</body>
</html>

