<?php
session_start();
require 'config/connection.php';

// Fetch user's profile picture
$stmt = $conn->prepare("SELECT picture FROM Users WHERE username = ?");
$stmt->bind_param("s", $_SESSION['username']);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$profile_picture = $user['picture'] ?? 'profile.png';
?>

<!DOCTYPE html>
<html lang="en">
    
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" sizes="32x32" href="images\YouCanHack.svg"/>
    <link rel="stylesheet" href="style.css" />
    <title>You Can Hack</title>
  </head>

  <body>
    <nav>
      <div class="nav-container">
        <div class="nav-left">
          <div class="nav-logo"><img src="images\YouCanHack.svg" alt="YouCanHack logo"/></div>
          <ul class="nav-links">
            <li>Hack Base</li>
            <li>Hack Community</li>
            <li>About</li>
          </ul>
        </div>

        <div class="nav-right">
          <a class="transparent-btn" href="logout.php">Log Out</a>
          <a class="profile-btn" href="profile.php">
            <img src="<?php echo $profile_picture === 'images/profile.svg' ? 'images/profile.svg' : 'uploads/' . $profile_picture; ?>" alt="Profile">
          </a>
        </div>
      </div>
    </nav>
    
    <main>
      <div class="main-container">
        

      </div>
    </main>

  </body>
</html>