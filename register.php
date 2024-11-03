<?php
require 'sql.php'; // This will ensure that we are connected to the database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture form data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['psw'];
    $confirm_password = $_POST['psw-repeat'];

    // Basic validation
    if ($password !== $confirm_password) {
        die("Passwords do not match.");
    }

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO Users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $hashed_password);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Registration successful for user: $username with email: $email";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="styles.css">
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
            <button type="submit" class="registerbtn">Register</button>
        </article>
    </form>
    <div class="change">
        <p>Already have an account? <a href="login.php">Log In</a></p>
    </div>
</body>
</html>
