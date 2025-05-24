<?php
//session_start();
require_once 'functions/db_connection.php'; // Adjust path if needed

$conn = loadDatabase();
$movie = $_GET['id'] ?? '';
$results = [];

if (trim($movie) !== '') {
    if ($conn instanceof PDO) {
        $stmt = $conn->prepare("SELECT * FROM movie_info WHERE movie_id = ?");
        $stmt->execute([$movie]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./vars.css">
  <link rel="stylesheet" href="./style.css">
  <link rel="stylesheet" href="./CSS/movie.css">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600&display=swap" rel="stylesheet">
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
  <title>SinePinas</title>
</head>

<body>
  
  <div class="desktop-1">
    <div class="rectangle-1">
      <div class="hero-content">
        <a href="index.php" alt="index_page">
          <h1>SinePinas</h1>
        </a>
        <p>Explore the best of Philippine movies</p>
      </div>
    </div>

    <div class="nav-right">
      <div class="search-container">
        <input type="text" placeholder="Search movies..." class="search-input">
        <button class="search-btn">
          <ion-icon name="search"></ion-icon>
        </button>
      </div>
      <button class="tagline-btn">Experience Filipino Movie Here</button>
      <a href="user_profile.php" class="register">
        <img class="fil" src="images/fil0.png" alt="user profile" />
      </a>
    </div>

    <div class="content-wrapper">
      <div class="left-section">
        <div class="movie-container">
          <div class="video-player">
            <iframe id="videoFrame" src="https://nextgencloudtools.com/embed/movie/tt4944352/"
              frameborder="0" allowfullscreen allow="autoplay; encrypted-media; fullscreen">
            </iframe>
          </div>

          <div class="movie-details">
            <h2>Heneral Luna</h2>
            <div class="movie-meta">
              <span class="year">2015</span>
              <span class="genre">Historical Drama</span>
              <span class="duration">2h 18m</span>
            </div>
            <div class="movie-description">
              <div class="description-poster">
                <img src="images/heneral_luna.jpg" alt="Heneral Luna Poster" style="width: 100%; height: 100%; object-fit: cover;">
              </div>
              <p>A historical biopic of Antonio Luna, a general in the Philippine Revolutionary Army who fought against the American occupation of the Philippines in 1899. The film follows his leadership and struggles as he tries to unite the Filipino forces against the American invaders, while dealing with political infighting and personal conflicts within the revolutionary government.</p>
            </div>
          </div>
        </div>
      </div>

      <div class="right-section">
        <div class="top-movies">Top Movies</div>
        <div class="top-movies-list">
          <div class="top-movie-item">
            <div class="movie-thumbnail"></div>
            <span class="rank">1</span>
            <div class="movie-info">
              <h3>Heneral Luna</h3>
              <p>2015 • Historical Drama</p>
            </div>
          </div>
          <div class="top-movie-item">
            <div class="movie-thumbnail"></div>
            <span class="rank">2</span>
            <div class="movie-info">
              <h3>Four Sisters and a Wedding</h3>
              <p>2013 • Comedy Drama</p>
            </div>
          </div>
          <div class="top-movie-item">
            <div class="movie-thumbnail"></div>
            <span class="rank">3</span>
            <div class="movie-info">
              <h3>On the Job</h3>
              <p>2013 • Crime Thriller</p>
            </div>
          </div>
          <div class="top-movie-item">
            <div class="movie-thumbnail"></div>
            <span class="rank">4</span>
            <div class="movie-info">
              <h3>The Hows of Us</h3>
              <p>2018 • Romance</p>
            </div>
          </div>
          <div class="top-movie-item">
            <div class="movie-thumbnail"></div>
            <span class="rank">5</span>
            <div class="movie-info">
              <h3>Metro Manila</h3>
              <p>2013 • Drama</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <footer class="footer">
      <div class="footer-content">
        <div class="footer-section">
          <h3>SinePinas</h3>
          <p>Your destination for Filipino cinema. Discover classic Filipino films.</p>
        </div>

        <div class="footer-section">
          <h4>Quick Links</h4>
          <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="home.php">Movies</a></li>
          </ul>
        </div>

        <div class="footer-section">
          <h4>Categories</h4>
          <ul>
            <li><a href="#">Romance</a></li>
            <li><a href="#">Comedy</a></li>
            <li><a href="#">Classic</a></li>
            <li><a href="#">Horror</a></li>
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
  </div>

  <script src="script.js"></script>
</body>

</html>