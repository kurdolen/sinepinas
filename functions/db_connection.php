<?php
// Load database connection
function loadDatabase(){
    session_start();

    // Database connection parameters
    $dbhost = "localhost";
    $db_username = "root";
    $db_password = "";
    $dbname = "sinepinas";

    $conn = new mysqli($dbhost, $db_username, $db_password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}
//     return $conn;
