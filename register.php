<?php
require 'config/connection.php'; // This will ensure that we are connected to the database

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    // Store registration form data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['psw'];
    $confirm_password = $_POST['psw-repeat'];

    // Check if passwords match
    if ($password !== $confirm_password) {
        $error_message = "Passwords do not match.";
    } else {
        // Check if email already exists
        $check_query = $conn->prepare("SELECT * FROM Users WHERE email = ?");
        if ($check_query) {
            $check_query->bind_param("s", $email);
            $check_query->execute();
            $result = $check_query->get_result();

            if ($result->num_rows > 0) {
                $error_message = "Email already exists. Please choose a different one.";
            } else {
                // Hash the password and insert new user data
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // Create prepared statement to prevent SQL injection attacks
                $stmt = $conn->prepare("INSERT INTO Users (username, email, password) VALUES (?, ?, ?)");
                if ($stmt) {
                    $stmt->bind_param("sss", $username, $email, $hashed_password);
                    if ($stmt->execute()) {
                        header("Location: login.php");
                        exit();
                    } else {
                        $error_message = "Error: " . $stmt->error;
                    }
                    $stmt->close();
                } else {
                    $error_message = "Failed to prepare insert statement.";
                }
                
            }
            $check_query->close();
        } else {
            $error_message = "Failed to prepare email check statement.";
        }
    }

    // Close the database connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form action="register.php" method="POST">
        <article>
            <h1 class="form-title">Create an Account</h1>
            <label for="username">Username</label>
            <input type="text" name="username" id="username" placeholder="Username" required><br>
            <label for="email">Email</label>
            <input type="email" name="email" id="email" placeholder="Email" required><br>
            <label for="psw">Password</label>
            <input type="password" name="psw" id="psw" placeholder="Password" required><br>
            <label for="psw-repeat">Confirm Password</label>
            <input type="password" name="psw-repeat" id="psw-repeat" placeholder="Password" required><br>
            <p id="form-error-message">
                <?php echo !empty($error_message) ? $error_message : ''; ?>
            </p>
            <button type="submit" class="formbtn" name="register">Register</button>
            <div class="form-change">
                <p>Already have an account? <a href="login.php">Log In</a></p>
            </div>
        </article>
    </form>
</body>
</html>
