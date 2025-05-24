<?php
session_start();
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
</head>
<body>
 
  <div class="index-bg">
    
    <div class="back-button">
      <a href="home.php">Back</a>
    </div>

    <div class="profile-container">

        <div class="user-photo"></div>
        <?php if (isset($_SESSION['username'])): ?>
            <h1>Hello <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>

            <div class="user-info">
                <div class="info-item">
                <ion-icon name="person-outline"></ion-icon>
                <span><b>Username:</b> <?php echo htmlspecialchars($_SESSION['username']); ?></span>
                </div>
                <div class="info-item">
                <ion-icon name="mail-outline"></ion-icon>
                <span><b>Email:</b> <?php echo htmlspecialchars($_SESSION['email']); ?></span>
                </div>
                <div class="info-item">
                <ion-icon name="calendar-outline"></ion-icon>
                <span><b>Member Since:</b> <?php echo htmlspecialchars($_SESSION['date_created']); ?></span>
                </div>
                <div class="info-item">
                <ion-icon name="videocam-outline"></ion-icon>
                <span><b>Movies Watched:</b> <?php echo htmlspecialchars($_SESSION['num_moviesWatched']); ?></span>
                </div>
            </div>
        <?php endif; ?>

        <div class="profile-buttons"><br><br>
            
            

            <a href="watch_history.php" class="history-btn">
                <ion-icon name="time-outline"></ion-icon>
                Watch History
            </a><br><br>

            <a href="functions/logout.php" class="logout-btn">
                <ion-icon name="person"></ion-icon>
                Logout
            </a>

        </div>



    </div>





  </div>

</body>
</html>