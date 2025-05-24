<?php
include 'functions/login_verification.php';

$watching = $_SESSION['watching'] ?? 0;

$searchQuery = $_GET['search'] ?? '';

if ($searchQuery) {
    $stmt = $conn->prepare("SELECT * FROM movie_info WHERE title LIKE ?");
    $likeQuery = "%$searchQuery%";
    $stmt->bind_param("s", $likeQuery);
    $stmt->execute();
    $result = $stmt->get_result();
    $_SESSION['search_results'] = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
} else {
    $_SESSION['search_results'] = [];
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
    <link rel="stylesheet" href="./toast.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600&display=swap" rel="stylesheet">

    <style>

    </style>
    <title>SinePinas</title>
</head>

<body>

    <div class="desktop-1">
        <div class="rectangle-1" src="images/main_bg.png">

        </div>

        <div class="top-movies"></div>
        <a href="#" class="classic">Drama</a>
        <a href="#" class="romance">Romance</a>
        <a href="#" class="comedy">Comedy</a>
        <a href="#" class="horror">Horror</a>
        <a href="#" class="history">Action</a>

        <div class="nav-right">
            <div class="search-container">
                <form action="#" method="GET">
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



        <!-- SAMPLE code for testing
         dito mapupunta mga search results -->
        <div class="search-results">
            <h2>Results</h2>
            <div>

                <table>

                    <tr>
                        <td>movie poster</td>
                        <td>
                            title
                            year
                            genre
                        </td>
                    </tr>

                </table>

            </div>
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