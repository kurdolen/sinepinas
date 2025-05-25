<?php
session_start();
// Database connection settings
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "sinepinas";
$_SESSION['isLoggedin'] = false;



// Connect to database
$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get user input from form
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// Query to find the user
$sql = "SELECT * FROM user_info WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

// Check if user exists
if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    // Check password
    if (password_verify($password, $user['user_password'])) {
        // Success stores user info in session variables
        echo "Login successful. Welcome, " . htmlspecialchars($username) . "!";
        $_SESSION['username'] = $user['username'] ?? null;
        $_SESSION['isLoggedin'] = true;
        $_SESSION['user_id'] = $user['user_id'] ?? null;
        $_SESSION['email'] = $user['email'] ?? null;
        $_SESSION['date_created'] = $user['date_created'] ?? null;
        $_SESSION['num_moviesWatched'] = $user['num_moviesWatched'] ?? null;
        
    } else {
        echo "Login failed. Please check your username and password.";
    }
}






?>