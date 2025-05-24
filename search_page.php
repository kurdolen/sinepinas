<?php
//session_start();
require_once 'functions/db_connection.php'; // Adjust path if needed

$conn = loadDatabase();
$searchQuery = $_GET['search'] ?? '';
$results = [];

if (trim($searchQuery) !== '') {
    if ($conn instanceof PDO) {
        $stmt = $conn->prepare("SELECT * FROM movie_info WHERE title LIKE ?");
        $stmt->execute(["%" . $searchQuery . "%"]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $stmt = $conn->prepare("SELECT * FROM movie_info WHERE title LIKE ?");
        $like = "%" . $searchQuery . "%";
        $stmt->bind_param("s", $like);
        $stmt->execute();
        $result = $stmt->get_result();
        $results = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Search Results</title>
   
    <style>
        .header {
            position: relative;
            width: 100%;
            min-height: 60px;
        }

        .header .search-form {
            position: absolute;
            top: 10px;
            right: 60px;
            /* leave space for register button */
            margin: 0;
            display: flex;
            align-items: center;
        }

        .header .search-input {
            padding: 6px 10px;
            font-size: 16px;
            width: 200px;
        }

        .header .search-btn {
            padding: 6px 12px;
            font-size: 16px;
        }

        .header .register {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 32px;
            height: 32px;
            z-index: 10;
        }

        .header .register .fil {
            width: 100%;
            height: auto;
            display: block;
        }
    </style>
    <style>
        .movie-card {
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        .movie-poster {
            width: 100px;
            height: auto;
            margin-right: 10px;
        }

        .home-link {
            color: inherit;
            text-decoration: none;
            font: inherit;

        }
    </style>
</head>

<body>
    <div class="header">
        <a href="home.php" class="home-link">See featured films</a>
        <form action="search_page.php" method="GET" class="search-form">
            <input type="text" name="search" placeholder="Search movies..." class="search-input" value="<?= htmlspecialchars($searchQuery) ?>">
            <input type="submit" value="Find" class="search-btn">
        </form>

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

    <div class="search-results">
        <?php if (trim($searchQuery) !== ''): ?>
            <p>Results for: <strong><?= htmlspecialchars($searchQuery) ?></strong></p>

            <?php if (!empty($results)): ?>
                <?php foreach ($results as $movie): ?>
                    <a href="movie-container.php?id=<?= urlencode($movie['movie_id']) ?>" style="text-decoration: none; color: inherit;">
                        <div class="movie-card" style="display: flex; align-items: center; cursor: pointer;">

                            <?php if (!empty($movie['poster_link'])): ?>
                                <img src="<?= htmlspecialchars($movie['poster_link']) ?>" alt="movie poster" class="movie-poster">
                            <?php else: ?>
                                <div class="no-image">
                                    No Image
                                </div>
                            <?php endif; ?>

                            <div>
                                <h3><?= htmlspecialchars($movie['title']) ?></h3>
                                <div>Genre: <?= htmlspecialchars($movie['genre'] ?? 'N/A') ?></div>
                                <div>Release Year: <?= htmlspecialchars($movie['release_year'] ?? 'N/A') ?></div>
                            </div>

                        </div>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No results found.</p>
            <?php endif; ?>
        <?php else: ?>
            <p>No results found.</p>
        <?php endif; ?>
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

</body>

</html>