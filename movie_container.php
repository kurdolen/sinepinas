<?php
//session_start();
require_once 'functions/db_connection.php'; // Adjust path if needed

$conn = loadDatabase();
$movie = (int)($_GET['id'] ?? 0);
$results = [];

if($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if (isset($movie)) {
  $stmt = $conn->prepare("SELECT * FROM movie_info WHERE movie_id = ?");
  $stmt->bind_param("i", $movie);
  $stmt->execute();
  $result = $stmt->get_result();
  $results = $result->fetch_assoc();
}


// checks if user is logged in, and record the movie watch history
if (isset($_SESSION['user_id'])) {
  $userId = $_SESSION['user_id'];
  // Check if this movie is already in the user's watch history
  $checkStmt = $conn->prepare("SELECT 1 FROM watch_history WHERE user_id = ? AND movie_id = ?");
  $checkStmt->bind_param("ii", $userId, $movie);
  $checkStmt->execute();
  $checkStmt->store_result();

  if ($checkStmt->num_rows === 0) {
    $stmt = $conn->prepare("INSERT INTO watch_history (user_id, movie_id, last_watch) VALUES (?, ?, NOW())");
    $stmt->bind_param("ii", $userId, $movie);
    $stmt->execute();
    $stmt->close();

    // Increment num_moviesWatched in user_info table
    $updateUserStmt = $conn->prepare("UPDATE user_info SET num_moviesWatched = num_moviesWatched + 1 WHERE user_id = ?");
    $updateUserStmt->bind_param("i", $userId);
    $updateUserStmt->execute();
    $updateUserStmt->close();
  } else {
    $updateStmt = $conn->prepare("UPDATE watch_history SET last_watch = NOW() WHERE user_id = ? AND movie_id = ?");
    $updateStmt->bind_param("ii", $userId, $movie);
    $updateStmt->execute();
    $updateStmt->close();
  }
  $checkStmt->close();
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
    <link rel="stylesheet" href="./CSS/featured-movie.css">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600&display=swap" rel="stylesheet">
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
  <title>SinePinas</title>
  <style>

      .nav-link{
            position: relative;
            top: 2px;
            left: 3px;
            color: #ffffff;
            text-decoration: none;
            font-size: 1.1em;
            padding: 10px 20px;
            border: 2px solid #c0392b;
            border-radius:home-link 4px;
            transition: all 0.3s ease;
        }

        .nav-link:hover{
            background: #c0392b;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(192, 57, 43, 0.4);
        }
  </style>


</head>

<body>
  
  <div class="desktop-1">
    <div class="rectangle-1">
      <div class="hero-content">
        <a href="home.php" alt="index_page">
          <h1>SinePinas</h1>
        </a>
        <p>Explore the best of Philippine movies</p>
      </div>
    </div>

    <div class="nav-bar">
      <a href="search_page.php?search=drama" class="romance">Drama</a>
      <a href="search_page.php?search=romance" class="romance">Romance</a>
      <a href="search_page.php?search=comedy" class="romance">Comedy</a>
      <a href="search_page.php?search=horror" class="romance">Horror</a>
      <a href="search_page.php?search=action" class="romance">Action</a>
    </div>

    <div class="nav-right">
      <div class="search-container">
        <form action="search_page.php" method="GET" class="search-form">
            <input type="text" name="search" placeholder="Search movies..." class="search-input">
            <input type="submit" value="Find" class="search-btn">
        </form>
      </div>
      <a href="home.php" class="nav-link">See Featured Movies</a>
    </div>

    <div class="content-wrapper">
      <div class="left-section">
        <div class="movie-container">
          <div class="video-player">
            <iframe id="videoFrame" src="<?php echo htmlspecialchars($results["movie_link"] ?? '', ENT_QUOTES); ?>"
              frameborder="0" allowfullscreen allow="autoplay; encrypted-media; fullscreen">
            </iframe>
          </div>

          <div class="movie-details">
            <h2><?php echo htmlspecialchars($results["title"] ?? '', ENT_QUOTES); ?></h2>
            <div class="movie-meta">
              <span class="year"><?php echo htmlspecialchars($results["release_year"] ?? '', ENT_QUOTES); ?></span>
              <span class="genre"><?php echo htmlspecialchars($results["genre"] ?? '', ENT_QUOTES); ?></span>
            </div>
            <div class="movie-description">
              <div class="description-poster">
                <img src="<?php echo htmlspecialchars($results["poster_link"] ?? '', ENT_QUOTES); ?>" 
                alt="Heneral Luna Poster" style="width: 100%; height: 100%; object-fit: cover;">
              </div>
              <p><?php echo htmlspecialchars($results["description"] ?? '', ENT_QUOTES); ?></p>
            </div>
          </div>
        </div>
      </div>
    <!--
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
    -->


  </div>

  <script src="script.js"></script>
</body>

</html>