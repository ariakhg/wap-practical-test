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

// Fetch hackathons from the database
$sql = "SELECT * FROM Hackathons WHERE status = 'upcoming' ORDER BY start_date ASC";
$result = $conn->query($sql);
$hackathons = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $hackathons[] = $row;
    }
} else {
    echo "No hackathons found.";
}

$conn->close();
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
            <li>Hack Base</></li>
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
      <div class="hackathon-container">
        <div class="hackathon-grid">
          <?php foreach ($hackathons as $hackathon): ?>
            <div class="hackathon-card" data-status="<?php echo $hackathon['status']; ?>">
              <div class="hackathon-image">
                <img src="<?php echo 'images/defaultHackathon.svg' ?>" 
                  alt="<?php echo $hackathon['title']; ?>">
                <span class="status-badge <?php echo $hackathon['status']; ?>">
                  <?php echo ucfirst($hackathon['status']); ?>
                </span>
              </div>
                        
              <div class="hackathon-content">
                <h2><?php echo $hackathon['title']; ?></h2>
                  <p class="description"><?php echo $hackathon['description']; ?></p>
                            
                  <div class="hackathon-details">
                    <div class="detail">
                      <span><?php echo date('M d', strtotime($hackathon['start_date'])); ?> - 
                        <?php echo date('M d, Y', strtotime($hackathon['end_date'])); ?></span>
                    </div>
                    <div class="detail">
                        <span><?php echo $hackathon['location']; ?></span>
                    </div>
                  </div>
                            
                  <a href="<?php echo $hackathon['url']; ?>" class="hackathon-btn" target="_blank">
                    Learn More
                  </a>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
        <p id="more">More Coming Soon!</p>
      </div>
    </main>
  </body>
</html>