<?php
session_start();

$searchQuery = $_GET['search'] ?? '';

if ($searchQuery) {
    $stmt = $conn->prepare("SELECT * FROM movie_info WHERE title LIKE ?");
    $stmt->execute(["%$searchQuery%"]);
    $_SESSION['search_results'] = $stmt->fetchAll();
} else {
    $_SESSION['search_results'] = [];
}

sleep(1);
header("Location: ../search_page.php");
exit();

?>
