<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['psw'];

    // Here you would typically check the username and password against a database
    // For demonstration, we'll just echo the values
    echo "Login successful for user: $username";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <form action="login.php" method="POST">
        <article>
            <h1 class="form-title">Log In</h1>
            <label for="username">Username</label>
            <input type="text" name="username" id="username" placeholder="Username" required><br>
            <label for="psw">Password</label>
            <input type="password" name="psw" id="psw" placeholder="Password" required><br>
            <button type="submit" class="registerbtn">Log In</button>
        </article>
    </form>
    <div class="change">
        <p>Don't have an account? <a href="register.php">Register</a></p>
    </div>
</body>
</html>