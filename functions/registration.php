<?php
session_start();
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "sinepinas";

$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

// check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['registerUsername'];
    $email = $_POST['registerEmail'];
    $password = $_POST['registerPassword'];

    // check if email or username already exists
    $check = "SELECT * FROM user_info WHERE username = '$username' OR email = '$email'";
    $result = $conn->query($check);

    if ($result && $result->num_rows > 0) {
        echo "Username or email already exists!";
    } else {
        // Insert into database
        $sql = "INSERT INTO user_info (username, email, user_password) 
                VALUES ('$username', '$email', '$password')";

                

        if ($conn->query($sql) === TRUE) {
            $sql = "SELECT * FROM user_info WHERE username = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            $user = $result->fetch_assoc(); 

            //sets registered user info in session variables, indicating that the user is logged in
            $_SESSION['user_info'] = $user;
            $_SESSION['username'] = $username;
            $_SESSION['user_id'] = $user['user_id'] ?? null;
            $_SESSION['email'] = $user['email'] ?? null;
            $_SESSION['date_created'] = $user['date_created'] ?? null;
            $_SESSION['num_moviesWatched'] = $user['num_moviesWatched'] ?? null;

            echo "Registration successful!";
        } else {
            echo "Error: " . $conn->error;
        }
    }
}

$conn->close();






?>