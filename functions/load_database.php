<?php


// Load database connection
function loadDatabase(){
    session_start();
    $dbhost = "localhost";
    $db_username = "root";
    $db_password = "";
    $database = "sinepinas";

    try {
        $conn = new mysqli($dbhost, $db_username, $db_password);

        // Check if database exists
        $sql = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$database'";
        $result = $conn->query($sql);
        // Create database if it doesn't exist
        if (!($result && $result->num_rows > 0)) {
            $create_db = "CREATE DATABASE IF NOT EXISTS `$database`";
            $conn->query($create_db);
        }

        // Select the database before creating tables
        $conn->select_db($database);

        // Create user_info table
        $create_userTable = "CREATE TABLE IF NOT EXISTS user_info (
            user_id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL UNIQUE,
            user_password VARCHAR(255) NOT NULL,
            date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            num_moviesWatched INT DEFAULT 0
        )";
        if (!$conn->query($create_userTable)) {
            echo "Error creating user_info: " . $conn->error;
        }

        // Create movie_info table
        $create_movieTable = "CREATE TABLE IF NOT EXISTS movie_info (
            movie_id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            release_year INT NOT NULL,
            genre VARCHAR(50) NOT NULL,
            description TEXT NOT NULL,
            poster_link VARCHAR(2083) NOT NULL,
            movie_link VARCHAR(2083) NOT NULL
        )";
        if (!$conn->query($create_movieTable)) {
            echo "Error creating movie_info: " . $conn->error;
        }

        // Create watch_history table
        $create_historyTable = "CREATE TABLE IF NOT EXISTS watch_history (
            history_id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            movie_id INT NOT NULL,
            last_watch TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES user_info(user_id) ON DELETE CASCADE,
            FOREIGN KEY (movie_id) REFERENCES movie_info(movie_id) ON DELETE CASCADE,
            UNIQUE (user_id, movie_id)
        )";
        if (!$conn->query($create_historyTable)) {
            echo "Error creating watch_history: " . $conn->error;
        }

    } catch (Exception $e) {
        echo "Connection failed: " . $e->getMessage();
    }

}

?>
