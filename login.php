<?php
session_start();
require 'config/connection.php';

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {

    //Store login form data
    $username = $_POST['username'];
    $password = $_POST['psw'];

    // Prepare and execute the SQL query to check for the username
    $stmt = $conn->prepare("SELECT password FROM Users WHERE username = ?");
    if ($stmt) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if the user exists
        if ($result->num_rows === 1) {
            // Retrieve the hashed password from Users database
            $row = $result->fetch_assoc();
            $hashed_password = $row['password'];

            // Verify the password
            if (password_verify($password, $hashed_password)) {
                //Store username in session
                $_SESSION['username'] = $username; 

                // Redirect to home page
                header("Location: home.php");
                exit();
            } else {
                $error_message = "Incorrect password.";
            }
        } else {
            // Username does not exist
            $error_message = "Incorrect username or password.";
        }

        $stmt->close();
    } else {
        $error_message = "SQL statement error.";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
      <nav>
        <!-- Navigation Bar -->
        <div class="nav-container">
          <div class="nav-left">
            <div class="nav-logo"><img src="images\youCanHack.svg" alt="YouCanHack logo"/></div>
            <ul class="nav-links">
              <li>About</li>
            </ul>
          </div>

          <div class="nav-right">
            <a class="transparent-btn" href="login.php">Login</a></li>
            <a class="outlined-btn" href="register.php">Register</a></li>
          </div>
        </div>
      </nav>
    </header>
    <form action="login.php" method="POST">
        <article>
            <h1 class="form-title">Log In</h1>
            <label for="username">Username</label>
            <input type="text" name="username" id="username" placeholder="Username" required><br>
            <label for="psw">Password</label>
            <input type="password" name="psw" id="psw" placeholder="Password" required><br>
            <p id="form-error-message">
                <?php echo !empty($error_message) ? $error_message : ''; ?>
            </p>
            <button type="submit" class="formbtn" name="login">Log In</button>
            <div class="form-change">
                <p>Don't have an account? <a href="register.php">Register</a></p>
            </div>
        </article>
    </form>
</body>
</html>