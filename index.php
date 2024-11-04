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

        <!-- <div class="mobile-menu-btn">
          <img src="./images/icon-menu.svg" alt="menu" />
        </div>
        <div class="mobile-menu">
          <ul class="mobile-links">
            <li>
              <p>
                Features
                <img
                  src="./images/icon-arrow-down.svg"
                  class="arrow"
                  alt="arrow down"
                />
              </p>
              <div class="mobile-sub">
                <p class="sub-link">
                  <img src="./images/icon-todo.svg" alt="icon" /> Todo List
                </p>
                <p class="sub-link">
                  <img src="./images/icon-calendar.svg" alt="icon" /> Calendar
                </p>
                <p class="sub-link">
                  <img src="./images/icon-reminders.svg" alt="icon" /> Reminders
                </p>
                <p class="sub-link">
                  <img src="./images/icon-planning.svg" alt="icon" /> Planning
                </p>
              </div>
            </li>
            <li>
              <p>
                Company
                <img
                  src="./images/icon-arrow-down.svg"
                  class="arrow"
                  alt="arrow down"
                />
              </p>

              <div class="mobile-sub">
                <p class="sub-link">History</p>
                <p class="sub-link">Our Team</p>
                <p class="sub-link">Blog</p>
              </div>
            </li>
            <li>Careers</li>
            <li>About</li>
          </ul>
        </div> -->

        <div class="nav-right">
          <a class="transparent-btn" href="login.php">Login</a></li>
          <a class="outlined-btn" href="register.php">Register</a></li>
        </div>
      </div>
    </nav>
    
    <main>
      <div class="main-container">
        <div class="main-left">
          <h1 class="main-heading">
            Welcome to You Can Hack
          </h1>
          <p class="main-content">
            Your go-to platform for discovering and joining hackathons worldwide. Explore, connect, and challenge yourself with the latest hackathons tailored for you. Sign up, stay updated, and start hacking today!
          </p>
          <a href="register.php" class="primary-btn">Register</a>
        </div>
        
        <div class="main-right">
          <picture>
            <source media="(max-width:800px)" srcset="./images/image-hero-mobile.png"/>
            <img src="images\LandingPhoto.svg" alt="Flowers" />
          </picture>
        </div>
      </div>
    </main>

    <!-- <div class="overflow"></div> -->
  </body>
  <script src="app.js"></script>
</html>