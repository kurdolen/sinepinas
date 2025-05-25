<?php
include 'functions/login_verification.php';
$watching = $_SESSION['watching'] ?? 0;



// establish manual database connection
$dbhost = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "sinepinas";

$connect = new mysqli($dbhost, $db_username, $db_password, $dbname);

if ($connect->connect_error) {
  die("Connection failed: " . $connect->connect_error);
} else {
  // Fetch all movies in the 'Action' category (assuming 'category' is the column name)
  $stmt = $connect->prepare("SELECT * FROM movie_info");
  //$stmt->bind_param("s", $category);
  $stmt->execute();
  $result = $stmt->get_result();
  $results = $result->fetch_all(MYSQLI_ASSOC);
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
  <link rel="stylesheet" href="./CSS/toast.css">
  <link rel="stylesheet" href="./CSS/featured-movie.css">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&display=swap" rel="stylesheet">

  <style>

  </style>
  <title>SinePinas</title>
</head>

<body>

  <div class="desktop-1">
    <div class="rectangle-1" src="images/main_bg.png">
      <div class="hero-content">
        <h1>SinePinas</h1>
        <p>Explore the best of Philippine cinema</p>
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
        <form action="functions/search.php" method="GET">
          <input type="text" name="search" placeholder="Search movies..." class="search-input">
          <input type="submit" value="Find" class="search-btn">
        </form>

      </div>

      <?php
      if (isset($_SESSION['user_id'])) {
        echo '<a href="user_profile.php" class="register" onclick="sessionStorage.setItem(\'entryPage\', window.location.href)">
                <img class="fil" src="images/fil0.png" alt="user profile" />
              </a>';
      } else {
        echo '<button class="login">
                Login
              </button>';
      }
      ?>

    </div>
    <div class="movie-grid"></div>

    <div class="episodes">Featured Movies</div>
    <div class="episodes-grid">

      <!--
      <div class="rectangle-12" title="The Hows of Us">
        <img src="https://i.pinimg.com/736x/71/2c/7d/712c7d31cf2a801c47f2afd81562b2cc.jpg" alt="The Hows of Us" />
        <div class="movie-info">
          <h3>The Hows of Us</h3>
          <p>2018 • Romance</p>
        </div>
      </div>
      <div class="rectangle-13" title="Metro Manila">
        <img src="https://m.media-amazon.com/images/M/MV5BNjg3MTgxNjA2NV5BMl5BanBnXkFtZTgwOTczNDY5NjE@._V1_FMjpg_UX1000_.jpg" alt="Metro Manila" />
        <div class="movie-info">
          <h3>Metro Manila</h3>
          <p>2013 • Drama</p>
        </div>
      </div>
      <div class="rectangle-14" title="Birdshot">
        <img src="https://m.media-amazon.com/images/M/MV5BMDdmMjhiMzItNWUwMi00ZDJkLTk0MWMtYTBjZjE2MzkyMTc2XkEyXkFqcGc@._V1_.jpg" alt="Birdshot" />
        <div class="movie-info">
          <h3>Birdshot</h3>
          <p>2016 • Thriller</p>
        </div>
      </div>
    -->

      <?php
      $i = 11;
      foreach ($results as $movie) {
        // Limit the number of displayed movies to 12
        if ($i == 20) break;
        echo '<a href="movie_container.php?id=' . urlencode($movie['movie_id']) . '">
          <div class="rectangle-' . $i . '" title="' . htmlspecialchars($movie['title'], ENT_QUOTES) . '">
            <img src="' . htmlspecialchars($movie['poster_link'], ENT_QUOTES) . '" alt="' . htmlspecialchars($movie['title'], ENT_QUOTES) . '" />
            <div class="movie-info">
              <h3>' . htmlspecialchars($movie['title'], ENT_QUOTES) . '</h3>
              <p>' . htmlspecialchars($movie['release_year'], ENT_QUOTES) . ' • ' . htmlspecialchars($movie['genre'], ENT_QUOTES) . '</p>
            </div>
          </div>
              </a>';
        $i++;
      }
      ?>



    </div>
  </div>

  <div class="wrapper">
    <span class="close-btn"><ion-icon name="close"></ion-icon></span>
    <div class="formbox">
      <h2>Login</h2>
      <form action="functions/login_verification.php" method="POST" id="loginForm">
        <div class="inputbox">
          <span class="icon"><ion-icon name="person"></ion-icon></span>
          <input type="text" name="username" required placeholder=" ">
          <label>Username</label>
        </div>
        <div class="inputbox">
          <span class="icon"><ion-icon name="lock-closed"></ion-icon>
          </span>
          <input type="password" name="password" required placeholder=" ">
          <label>Password</label>
        </div>
        <button type="submit" class="login-btn">Login</button>
        <div class="signup-link">
          <p>Don't have an account? <a href="#" class="register-link">Sign up</a></p>
        </div>
      </form>
    </div>

    <div class="formbox-register">
      <h2>Registration</h2>
      <form action="functions/registration.php" method="post" id="registerForm">
        <div class="inputbox">
          <span class="icon"><ion-icon name="person"></ion-icon></span>
          <input type="text" name="registerUsername" required>
          <label>Username</label>
        </div>
        <div class="inputbox">
          <span class="icon"><ion-icon name="mail"></ion-icon></span>
          <input type="email" name="registerEmail" required>
          <label>Email</label>
        </div>

        <div class="inputbox">
          <span class="icon"><ion-icon name="lock-closed"></ion-icon>
          </span>
          <input type="password" name="registerPassword" required>
          <label>Password</label>
        </div>
        <div class="remember">
          <label>
            <input type="checkbox" required>I agree to the terms and conditions
          </label>
        </div>
        <button type="submit" class="login-btn">Register</button>
        <div class="signup-link">
          <p>Already have an account? <a href="#" class="login-link">Log in</a></p>
        </div>
      </form>
    </div>
  </div>

  <footer class="footer">
    <div class="footer-content">
      <div class="footer-section">
        <h3>SinePinas!</h3>
        <p>Your ultimate destination for Filipino cinema. Discover classic Filipino films.</p>
      </div>

      <div class="footer-section">
        <h4>Navigate</h4>
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="#">Explore Movies</a></li>
        </ul>
      </div>

      <div class="footer-section">
        <h4>Categories</h4>
        <ul>
          <li><a href="search_page.php?search=drama">Drama</a></li>
          <li><a href="search_page.php?search=romance">Romance</a></li>
          <li><a href="search_page.php?search=comedy">Comedy</a></li>
          <li><a href="search_page.php?search=horror">Horror</a></li>
          <li><a href="search_page.php?search=action">Action</a></li>
        </ul>
      </div>

      <div class="footer-section">
        <h4>Connect With Us</h4>
        <div class="social-links">
          <a href="https://www.facebook.com/photo/?fbid=808436040462214&set=ecnf.100038874768873"><ion-icon name="logo-facebook"></ion-icon></a>
          <a href="https://youtu.be/vvFSVIy1Nqs?si=pUvrrhc5r0uzDbeA"><ion-icon name="logo-twitter"></ion-icon></a>
          <a href="https://www.instagram.com/lemskipepsi?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw=="><ion-icon name="logo-instagram"></ion-icon></a>
          <a href="https://www.youtube.com/watch?v=xvFZjo5PgG0"><ion-icon name="logo-youtube"></ion-icon></a>
        </div>
      </div>
    </div>

    <div class="footer-bottom">
      <p>&copy; SinePinas. All rights reserved.</p>
    </div>
  </footer>

  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
  <script src="toast.js"></script>
  <script src="script.js"></script>
</body>

</html>