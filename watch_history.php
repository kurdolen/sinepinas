<?php
require_once 'functions/db_connection.php'; // Include your database connection file
$conn = loadDatabase();

// gets the user id loggined in
if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];
}
// Fetch user information
$history_results = [];
$movie_info = [];

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if (isset($user_id)) {
  // Prepare and execute the query to fetch user information
  $stmt = $conn->prepare("SELECT movie_id, last_watch FROM watch_history WHERE user_id = ? ORDER BY last_watch DESC");
  $stmt->bind_param("i", $user_id);
  $stmt->execute();
  $result = $stmt->get_result();
  while ($row = $result->fetch_assoc()) {
    $history_results[] = $row;
  }
}

// fetch movie information for each movie_id in the watch history
foreach ($history_results as $item) {
  $movie_id = $item['movie_id'];
  $stmt = $conn->prepare("SELECT title, poster_link FROM movie_info WHERE movie_id = ?");
  $stmt->bind_param("i", $movie_id);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
    $movie_info[$movie_id] = $result->fetch_assoc();
  }
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
  <link rel="stylesheet" href="./index.css">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600&display=swap" rel="stylesheet">

  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
  <script src="script.js"></script>
  <script src="index.js"></script>

  <title>SinePinas</title>
<style>
  .history-container {
    width: 90%;
    max-width: 800px;
    margin: 40px auto;
    background-color: #000;
    padding: 30px;
    border-radius: 20px;
    color: white;
  }
  
  .history-list {
    display: flex;
    flex-direction: column;
    gap: 20px;
    padding-left: 25px;
  }
  
  .history-row {
    display: flex;
    gap: 20px;
    background: #1a1a1a;
    padding: 15px;
    border-radius: 12px;
    align-items: center;
    transition: transform 0.3s ease;
    margin-left: 25px;
  }
  
  .history-row:hover {
    transform: translateX(10px);
    background: #2a2a2a;
  }
  
  .history-poster-link {
    width: 100px;
    height: 150px;
    background-color: #000;
    overflow: hidden;
    border-radius: 8px;
    flex-shrink: 0;
    position: relative;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  }
  
  .history-poster {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
    display: block;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    transition: transform 0.3s ease;
  }
  
  .history-row:hover .history-poster {
    transform: scale(1.05);
  }
  
  .history-info {
    flex: 1;
    min-width: 0;
  }
  
  .history-title {
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 8px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    color: #fff;
  }
  
  .history-time {
    font-size: 14px;
    color: #ccc;
  }
    @media (max-width: 1200px) {
        .history-row {
            width: 30%;
        }
    }

    @media (max-width: 992px) {
        .history-row {
            width: 45%;
        }
    }

    @media (max-width: 768px) {
        .history-row {
            width: 80%;
        }
    }

    .history-container{
        position: relative;
        background-color: black;
        font-family: var(--primary-font);
        margin-top: 25px;
        margin-bottom: 25px;
        margin-left: 30%;
        margin-right: 30%;

        padding-top: 10px;
        padding-bottom: 50px;

        border-radius: 50px;
    }
    .history-container .line{
        border: none;
        height: 2px;
        background-color: #333;
        width: 80%;
        margin: 20px auto; 
    }

    .history-container h1{
        position: relative;
        color: white;
        text-align: center;
        padding-top: 20px;
        font-size: 10% auto;
    }

    .history-container .mov-container{
        position: relative;
        background-color: gray;
        margin: 0 auto 0 auto;
        width: 90%;
        height: 200px;
    }

    @media (max-width: 768px) {
        .history-container {
            width: 95%;
            padding: 20px;
            margin: 20px auto;
        }
        
        .history-row {
            flex-direction: column;
            text-align: center;
            padding: 15px;
            align-items: center;
        }
        
        .history-poster-link {
            width: 120px;
            height: 180px;
            margin: 0 auto;
        }
        
        .history-info {
            width: 100%;
            text-align: center;
            margin-top: 15px;
        }
        
        .history-title {
            font-size: 16px;
            margin-top: 10px;
        }
        
        .history-time {
            font-size: 12px;
        }
    }

    @media (max-width: 480px) {
        .history-container {
            padding: 15px;
        }
        
        .history-poster-link {
            width: 100px;
            height: 150px;
        }
        
        .history-title {
            font-size: 14px;
        }
    }

</style>
</head>

<body>
  <div class="index-bg">
    <div class="back-button">
      <a href="user_profile.php">Back</a>
    </div>



    <div class="history-container">
      <h1>Watch History</h1>
      <hr class="line">
      <div class="history-list">





        <!--
        <div class="history-row">
          <a href="#" class="history-poster-link"><div class="history-poster"></div></a>
          <div class="history-title">Heneral Luna</div>
        </div>
        -->




        <!-- Loop through the watch history results -->
        <?php foreach ($history_results as $item): ?>
          <?php
          $movie_id = $item['movie_id'];
          if (isset($movie_info[$movie_id])) {
            $title = $movie_info[$movie_id]['title'];
            $poster_link = $movie_info[$movie_id]['poster_link'];
          }
          ?>

          <div class="history-row">
            <a href="#" class="history-poster-link">
              <div class="history-poster" style="background-image: url('<?php echo htmlspecialchars($poster_link); ?>');"></div>
            </a>
            <div class="history-title"><?php echo htmlspecialchars($title); ?></div>
            <div class="history-time"><?php echo "Last time watched:" . htmlspecialchars($item['last_watch']); ?></div>
          </div>

        <?php endforeach; ?>



      </div>
    </div>





  </div>
</body>

</html>