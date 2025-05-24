<?php
include 'functions/login_verification.php';
$watching = $_SESSION['watching'] ?? 0;

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./vars.css">
  <link rel="stylesheet" href="./style.css">
  <link rel="stylesheet" href="./toast.css">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600&display=swap" rel="stylesheet">

  <style>

  </style>
  <title>SinePinas</title>
</head>

<body>

  <div class="desktop-1">
    <div class="rectangle-1" src="images/main_bg.png">
      <div class="hero-content">
        <a href="index.php" alt="index_page">
          <h1>SinePinas</h1>
        </a>

        <p>Explore the best of Philippine movies</p>
      </div>
    </div>

    <div class="top-movies"></div>
    <a href="#" class="classic">Drama</a>
    <a href="#" class="romance">Romance</a>
    <a href="#" class="comedy">Comedy</a>
    <a href="#" class="horror">Horror</a>
    <a href="#" class="history">Action</a>
    <div class="nav-right">
      <div class="search-container">
        <form action="functions/search.php" method="GET">
          <input type="text" name="search" placeholder="Search movies..." class="search-input">
          <input type="submit" value="Find" class="search-btn">
        </form>

      </div>

      <?php
      if (isset($_SESSION['user_id'])) {
        echo '<a href="user_profile.php" class="register">
                <img class="fil" src="images/fil0.png" alt="user profile" />
              </a>';
      } else {
        echo '<button class="login">
                Login
              </button>';
      }
      ?>

    </div>

    <div class="movie-grid">
      <!--
      <div class="rectangle-2" title="The Hows of Us">
        <div class="movie-info">
          <h3>The Hows of Us"></h3>
          <p>2015 • Historical Drama</p>
        </div>
      </div>
      <div class="rectangle-8" title="Four Sisters and a Wedding">
        <div class="movie-info">
          <h3>Four Sisters and a Wedding</h3>
          <p>2013 • Comedy Drama</p>
        </div>
      </div>
      <div class="rectangle-11" title="On the Job">
        <div class="movie-info">
          <h3>On the Job</h3>
          <p>2013 • Crime Thriller</p>
        </div>
      </div>
      -->
    </div>

    <div class="episodes">Featured Movies</div>
    <div class="episodes-grid">
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

      
      <div class="rectangle-15"></div>
      <div class="rectangle-16"></div>
      <div class="rectangle-17"></div>
      <div class="rectangle-18"></div>
      <div class="rectangle-19"></div>
      <div class="rectangle-20"></div>
      <div class="rectangle-21"></div>
      <div class="rectangle-22"></div>
      <div class="rectangle-23"></div>
      <div class="rectangle-24"></div>
      <div class="rectangle-25"></div>
      <div class="rectangle-26"></div>
      <div class="rectangle-27"></div>
      <div class="rectangle-28"></div>
      <div class="rectangle-29"></div>
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
        <div class="remember">
          <label>
            <input type="checkbox">Remember me
          </label>
          <a href="#">Forgot Password?</a>
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
          <li><a href="#">Home</a></li>
          <li><a href="#">Explore Movies</a></li>
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
          <a href="#"><ion-icon name="logo-facebook"></ion-icon></a>
          <a href="#"><ion-icon name="logo-twitter"></ion-icon></a>
          <a href="#"><ion-icon name="logo-instagram"></ion-icon></a>
          <a href="#"><ion-icon name="logo-youtube"></ion-icon></a>
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