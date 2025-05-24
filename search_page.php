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
    
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Montserrat:wght@300;400;600&display=swap" rel="stylesheet">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <link rel="stylesheet" href="./toast.css">
    <style>
      
:root {

  --primary-color: #000000;
  --secondary-color: #ffffff;
  --background-color: #f5f5f5;
  --text-color: #333333;
  

  --primary-font: 'Arial', sans-serif;
  --heading-font: 'Arial', sans-serif;
  
  
  --box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  --transition: all 0.3s ease;
}


        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: var(--primary-font);
        }

        body {
            background-color: #0a0a0a;
            color: #ffffff;
            line-height: 1.6;
        }

        .header {
            position: relative;
            width: 100%;
            min-height: 200px;
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)),
                        url(./images/main_bg.png);
            background-size: cover;
            background-position: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .header-content {
            text-align: center;
            margin-bottom: 30px;
        }

        .header-title {
            font-family: 'Arial';
            font-size: 2.5em;
            color: #ffffff;
            margin-bottom: 15px;
            letter-spacing: 2px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .movie-quote {
            font-family: 'Playfair Display', serif;
            font-style: italic;
            font-size: 1.2em;
            color: #c0392b;
            margin-bottom: 20px;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
            max-width: 800px;
            margin: 0 auto 20px;
        }

        .quote-author {
            font-size: 0.9em;
            color: #b3b3b3;
            font-style: normal;
        }

        .home-link {
            position: absolute;
            top: 20px;
            left: 20px;
            color: #ffffff;
            text-decoration: none;
            font-size: 1.1em;
            padding: 10px 20px;
            border: 2px solid #c0392b;
            border-radius: 4px;
            transition: all 0.3s ease;
        }

        .home-link:hover {
            background: #c0392b;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(192, 57, 43, 0.4);
        }

        .header .search-form {
            position: relative;
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            gap: 10px;
            background: rgba(0, 0, 0, 0.5);
            padding: 15px;
            border-radius: 8px;
            backdrop-filter: blur(5px);
        }

        .header .search-input {
            flex: 1;
            padding: 15px 25px;
            font-size: 16px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 4px;
            color: #ffffff;
            transition: all 0.3s ease;
        }

        .header .search-input:focus {
            outline: none;
            border-color: #c0392b;
            background: rgba(255, 255, 255, 0.15);
            box-shadow: 0 0 15px rgba(192, 57, 43, 0.3);
        }

        .header .search-btn {
            padding: 15px 30px;
            font-size: 16px;
            background: #c0392b;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: 'Montserrat', sans-serif;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .header .search-btn:hover {
            background: #a93226;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(192, 57, 43, 0.4);
        }

        .header .register {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 40px;
            height: 40px;
            z-index: 10;
            transition: transform 0.3s ease;
            background: rgba(0, 0, 0, 0.5);
            border-radius: 50%;
            padding: 5px;
        }

        .header .register:hover {
            transform: scale(1.1);
            box-shadow: 0 0 15px rgba(192, 57, 43, 0.4);
        }

        .header .login {
            position: absolute;
            top: 20px;
            right: 20px;
            padding: 10px 25px;
            background: #c0392b;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-family: 'Montserrat', sans-serif;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .header .login:hover {
            background: #a93226;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(192, 57, 43, 0.4);
        }

        .header .register .fil {
            width: 100%;
            height: auto;
            display: block;
        }

        .search-results {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .search-results p {
            font-family: 'Playfair Display', serif;
            font-size: 24px;
            margin-bottom: 30px;
            color: #c0392b;
            text-align: center;
            padding: 40px 20px;
            background: rgba(0, 0, 0, 0.3);
            border-radius: 8px;
            border: 1px solid rgba(192, 57, 43, 0.3);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            letter-spacing: 1px;
            line-height: 1.6;
            font-style: italic;
        }

        .search-results p strong {
            color: #ffffff;
            font-weight: 700;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .movie-card {
            background: linear-gradient(to right, #1a1a1a, #2a2a2a);
            padding: 20px;
            margin: 20px 0;
            border-radius: 8px;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .movie-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
            border-color: #c0392b;
        }

        .movie-poster {
            width: 120px;
            height: 180px;
            object-fit: cover;
            border-radius: 4px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .movie-card h3 {
            font-family: 'Playfair Display', serif;
            font-size: 24px;
            margin-bottom: 10px;
            color: #ffffff;
        }

        .movie-card div {
            color: #b3b3b3;
            font-size: 14px;
            margin: 5px 0;
        }

        .no-image {
            width: 120px;
            height: 180px;
            background: #2a2a2a;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #666;
            font-size: 14px;
            border-radius: 4px;
        }

        .wrapper {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
            max-width: 420px;
            background: rgba(0, 0, 0, 0.85);
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(139, 69, 19, 0.4);
            z-index: 1000;
            display: none;
            border: 2px solid #ff0a0e;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        .wrapper.active-popup {
            transform: scale(1);
        }

        .formbox {
            display: block;
        }

        .formbox-register {
            display: none;
        }

        .wrapper.active .formbox {
            display: none;
        }

        .wrapper.active .formbox-register {
            display: block;
        }

        .wrapper .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 30px;
            height: 30px;
            background: #f0f0f0;
            font-size: 20px;
            color: #333333;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 1001;
        }

        .wrapper .close-btn:hover {
            background: #ff0a0e;
            color: white;
        }

        .wrapper .close-btn ion-icon {
            font-size: 20px;
        }

        .formbox h2 {
            color: #ff0a0e;
            font-size: 28px;
            margin-bottom: 25px;
            font-weight: 600;
            text-align: center;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .formbox form {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .inputbox {
            position: relative;
            margin-bottom: 20px;
        }

        .inputbox input {
            width: 100%;
            padding: 12px 12px 12px 40px;
            border: 1px solid #ff0a0e;
            border-radius: 6px;
            font-size: 15px;
            color: black;
            transition: all 0.3s ease;
            background: white;
        }

        .inputbox input:focus {
            outline: none;
            border-color: #ff0a0e;
            box-shadow: 0 0 8px rgba(139, 69, 19, 0.3);
        }

        .inputbox .icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #ff0a0e;
            font-size: 18px;
        }

        .inputbox label {
            position: absolute;
            left: 40px;
            top: 50%;
            transform: translateY(-50%);
            color: black;
            pointer-events: none;
            transition: 0.3s;
        }

        .inputbox input:focus ~ label,
        .inputbox input:valid ~ label {
            top: -10px;
            left: 12px;
            font-size: 12px;
            background: white;
            padding: 0 4px;
            color: #ff0a0e;
        }

        .remember {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .remember label {
            display: flex;
            align-items: center;
            gap: 8px;
            color: white;;
            font-size: 14px;
            cursor: pointer;
        }

        .remember input[type="checkbox"] {
            width: 16px;
            height: 16px;
            margin: 0;
            cursor: pointer;
        }

        .remember a {
            color: #ff0a0e;
            font-size: 14px;
            text-decoration: none;
        }

        .remember a:hover {
            color: #ffffff;
        }

        .login-btn {
            width: 100%;
            padding: 12px;
            background: #ff0a0e;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .login-btn:hover {
            background: #cc080b;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(139, 69, 19, 0.3);
        }

        .signup-link {
            text-align: center;
            margin-top: 20px;
            font-size: 15px;
            color: #ffffff;
        }

        .signup-link a {
            color: #ff0a0e;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .signup-link a:hover {
            color: #ffffff;
            text-shadow: 0 0 8px rgba(255, 10, 14, 0.5);
        }

        .formbox-register {
            background: #000000;
            padding: 20px;
            border-radius: 8px;
        }

        .formbox-register h2 {
            color: #ff0a0e;
            font-size: 28px;
            margin-bottom: 25px;
            font-weight: 600;
            text-align: center;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        }

        .formbox-register .inputbox input {
            width: 100%;
            padding: 12px 12px 12px 40px;
            border: 1px solid #ff0a0e;
            border-radius: 6px;
            font-size: 15px;
            color: black;
            transition: all 0.3s ease;
            background: white;
        }

        .formbox-register .inputbox label {
            position: absolute;
            left: 40px;
            top: 50%;
            transform: translateY(-50%);
            color: black;
            pointer-events: none;
            transition: all 0.3s ease;
            font-size: 15px;
            background: transparent;
        }

        .formbox-register .inputbox input:focus ~ label,
        .formbox-register .inputbox input:valid ~ label {
            top: -10px;
            left: 12px;
            font-size: 12px;
            background: white;
            padding: 0 4px;
            color: #ff0a0e;
        }

        .formbox-register .inputbox input:focus {
            outline: none;
            border-color: #ff0a0e;
            box-shadow: 0 0 8px rgba(139, 69, 19, 0.2);
        }

        .formbox-register .inputbox .icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #ff0a0e;
            font-size: 18px;
        }

        .formbox-register .remember {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .formbox-register .remember label {
            color: #ffffff;
            font-size: 15px;
        }

        .formbox-register .remember a {
            color: #ff0a0e;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .formbox-register .remember a:hover {
            color: #cc080b;
        }

        .formbox-register .login-btn {
            width: 100%;
            padding: 12px;
            background: #ff0a0e;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .formbox-register .login-btn:hover {
            background: #cc080b;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(139, 69, 19, 0.3);
        }

        .formbox-register .signup-link {
            text-align: center;
            margin-top: 20px;
            font-size: 15px;
            color: #ffffff;
        }

        .formbox-register .signup-link a {
            color: #ff0a0e;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .formbox-register .signup-link a:hover {
            color: #cc080b;
        }

        .no-results {
            text-align: center;
            padding: 40px 20px;
            background: rgba(0, 0, 0, 0.3);
            border-radius: 8px;
            border: 1px solid rgba(192, 57, 43, 0.3);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            color: #ffffff;
            font-family: 'Playfair Display', serif;
            font-size: 24px;
            font-style: italic;
            letter-spacing: 1px;
            line-height: 1.6;
            margin: 20px 0;
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {
            0% {
                opacity: 0.6;
            }
            50% {
                opacity: 1;
            }
            100% {
                opacity: 0.6;
            }
        }
    </style>
</head>

<body>
    <div class="header">
        <a href="home.php" class="home-link">See featured films</a>
        <div class="header-content">
            <h1 class="header-title">SinePinas</h1>
            <div class="movie-quote">
            “May mas malaki tayong kalaban sa mga Amerikano–ang ating sarili.”
                <div class="quote-author">- Heneral Luna</div>
            </div>
        </div>
        <form action="search_page.php" method="GET" class="search-form">
            <input type="text" name="search" placeholder="Search for your next favorite movie..." class="search-input" value="<?= htmlspecialchars($searchQuery) ?>">
            <input type="submit" value="Search" class="search-btn">
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
        <?php if (isset($_GET['search']) && trim($_GET['search']) !== ''): ?>
            <p>Results for: <strong><?= htmlspecialchars($_GET['search']) ?></strong></p>

            <?php if (!empty($results)): ?>
                <?php foreach ($results as $movie): ?>
                    <a href="movie_container.php?id=<?= urlencode($movie['movie_id']) ?>" style="text-decoration: none; color: inherit;">
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
                <p>No movies found for <strong>"<?= htmlspecialchars($_GET['search']) ?>"</strong></p>
            <?php endif; ?>
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
                    <span class="icon"><ion-icon name="lock-closed"></ion-icon></span>
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
                    <span class="icon"><ion-icon name="lock-closed"></ion-icon></span>
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

    <script>
        document.querySelector('.login').addEventListener('click', function() {
            document.querySelector('.wrapper').style.display = 'block';
            document.querySelector('.formbox').style.display = 'block';
            document.querySelector('.formbox-register').style.display = 'none';
        });

        document.querySelector('.close-btn').addEventListener('click', function() {
            document.querySelector('.wrapper').style.display = 'none';
        });

        document.querySelector('.register-link').addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelector('.formbox').style.display = 'none';
            document.querySelector('.formbox-register').style.display = 'block';
        });

        document.querySelector('.login-link').addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelector('.formbox').style.display = 'block';
            document.querySelector('.formbox-register').style.display = 'none';
        });

        // Search functionality
        const searchForm = document.querySelector('.search-form');
        const searchInput = document.querySelector('.search-input');
        const searchBtn = document.querySelector('.search-btn');
        const searchResults = document.querySelector('.search-results');

        // Function to handle search
        function handleSearch(query) {
            if (query) {
                // Update URL without reloading the page
                const newUrl = `search_page.php?search=${encodeURIComponent(query)}`;
                window.history.pushState({ path: newUrl }, '', newUrl);
                
                // Show loading state
                searchResults.style.display = 'block';
                searchResults.innerHTML = '<p>Searching...</p>';

                // Fetch search results
                fetch(`search_page.php?search=${encodeURIComponent(query)}`)
                    .then(response => response.text())
                    .then(html => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        const newResults = doc.querySelector('.search-results');
                        if (newResults) {
                            searchResults.innerHTML = newResults.innerHTML;
                        }
                    })
                    .catch(error => {
                        searchResults.innerHTML = '<p>Error performing search. Please try again.</p>';
                    });
            }
        }

        // Handle form submission
        searchForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const query = searchInput.value.trim();
            handleSearch(query);
        });

        // Handle search button click
        searchBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const query = searchInput.value.trim();
            handleSearch(query);
        });

        // Show search results if there's a search query in URL
        if (window.location.search.includes('search=')) {
            const urlParams = new URLSearchParams(window.location.search);
            const searchQuery = urlParams.get('search');
            if (searchQuery) {
                searchInput.value = searchQuery;
                handleSearch(searchQuery);
            }
        } else {
            searchResults.style.display = 'none';
        }
    </script>
  <script>
    class Toast {
    constructor() {
        this.container = document.createElement('div');
        this.container.className = 'toast-container';
        document.body.appendChild(this.container);
    }

    show(message, type = 'success', duration = 3000) {
        const toast = document.createElement('div');
        toast.className = `toast ${type}`;
        
        const icon = type === 'success' ? 'checkmark-circle' : 'alert-circle';
        
        toast.innerHTML = `
            <div class="toast-content">
                <ion-icon name="${icon}" class="toast-icon"></ion-icon>
                <span>${message}</span>
            </div>
            <button class="toast-close">
                <ion-icon name="close"></ion-icon>
            </button>
        `;

        this.container.appendChild(toast);

        // Add show class after a small delay to trigger animation
        setTimeout(() => {
            toast.classList.add('show');
        }, 10);

        // Add click event to close button
        const closeBtn = toast.querySelector('.toast-close');
        closeBtn.addEventListener('click', () => {
            this.hide(toast);
        });

        // Auto hide after duration
        if (duration > 0) {
            setTimeout(() => {
                this.hide(toast);
            }, duration);
        }

        return toast;
    }

    hide(toast) {
        toast.classList.remove('show');
        setTimeout(() => {
            toast.remove();
        }, 300); // Match the transition duration
    }

    success(message, duration = 3000) {
        return this.show(message, 'success', duration);
    }

    error(message, duration = 3000) {
        return this.show(message, 'error', duration);
    }
}

// Create global toast instance
window.toast = new Toast();

// Login and Registration Form Handling
document.addEventListener('DOMContentLoaded', function() {
    // Login form handling
    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            
            fetch('functions/login_verification.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                if (data.includes('Login successful')) {
                    toast.success('Login successful!');
                    setTimeout(() => {
                        window.location.href = 'search_page.php';
                    }, 1500);
                } else {
                    toast.error(data || 'Login failed. Please try again.');
                }
            })
            .catch(error => {
                toast.error('An error occurred. Please try again.');
            });
        });
    }

    // Registration form handling
    const registerForm = document.getElementById('registerForm');
    if (registerForm) {
        registerForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            
            fetch('functions/registration.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                if (data.includes('Registration successful')) {
                    toast.success('Registration successful! Please login.');
                    setTimeout(() => {
                        document.querySelector('.formbox-register').style.display = 'none';
                        document.querySelector('.formbox').style.display = 'block';
                    }, 1500);
                } else {
                    toast.error(data || 'Registration failed. Please try again.');
                }
            })
            .catch(error => {
                toast.error('An error occurred. Please try again.');
            });
        });
    }

    // Search functionality
    const searchInput = document.querySelector('.search-input');
    const searchBtn = document.querySelector('.search-btn');
    const searchResults = document.querySelector('.search-results');
    let searchTimeout;

    function showSearchResults() {
        searchResults.classList.add('show');
    }

    function hideSearchResults() {
        searchResults.classList.remove('show');
    }

    function performSearch(query) {
    fetch(`live_search.php?search=${encodeURIComponent(query)}`)
        .then(response => response.json())
        .then(movies => {
            if (movies.length > 0) {
                searchResults.innerHTML = movies.map(movie => `
                    <div class="search-result-item">
                        <img src="${movie.poster_link || 'images/placeholder.png'}" alt="${movie.title}">
                        <div class="search-result-info">
                            <h4>${movie.title}</h4>
                            <p>${movie.release_year} • ${movie.genre}</p>
                        </div>
                    </div>
                `).join('');
            } else {
                searchResults.innerHTML = '<div class="no-results">No results found.</div>';
            }
        })
        .catch(error => {
            console.error('Search error:', error);
            searchResults.innerHTML = '<div class="no-results">Searching....</div>';
        });
}


    if (searchBtn && searchInput && searchResults) {
        searchBtn.addEventListener('click', () => {
            const query = searchInput.value.trim();
            if (query) {
                performSearch(query);
                showSearchResults();
            }
        });

        searchInput.addEventListener('input', (e) => {
            const query = e.target.value.trim();
            clearTimeout(searchTimeout);
            
            if (query) {
                searchTimeout = setTimeout(() => {
                    performSearch(query);
                    showSearchResults();
                }, 300);
            } else {
                hideSearchResults();
            }
        });

        // Close search results when clicking outside
        document.addEventListener('click', (e) => {
            if (!searchResults.contains(e.target) && 
                !searchInput.contains(e.target) && 
                !searchBtn.contains(e.target)) {
                hideSearchResults();
            }
        });

        // Handle search result item clicks
        searchResults.addEventListener('click', (e) => {
            const resultItem = e.target.closest('.search-result-item');
            if (resultItem) {
                const movieTitle = resultItem.querySelector('h4').textContent;
                // Handle movie selection - you can redirect to movie details page
                console.log('Selected movie:', movieTitle);
                hideSearchResults();
            }
        });
    }
}); 

    </script>
</body>

</html>
