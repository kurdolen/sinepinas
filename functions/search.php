<?php
$searchQuery = $_GET['search'] ?? '';

if (trim($searchQuery) !== '') {
    header("Location: ../search_page.php?search=" . urlencode($searchQuery));
    exit();
}else {
    // Redirect to the home page if no search query is provided
    header("Location: ../home.php");
    exit();
}
?>
