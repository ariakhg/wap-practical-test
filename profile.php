<?php
require 'config/connection.php';
session_start();

$error_message = "";
$success_message = "";
$default_image = 'images/profile.svg';

// Retrieve user data
function getUserData($conn, $username) {
    $stmt = $conn->prepare("SELECT email, password, picture FROM Users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

// Update user data function
function updateUser($conn, $username, $new_username, $new_email, $new_password = null) {
    if ($new_password) {
        // Update with password
        $stmt = $conn->prepare("UPDATE Users SET username = ?, email = ?, password = ? WHERE username = ?");
        $stmt->bind_param("ssss", $new_username, $new_email, $new_password, $username);
    } 
    else {
        // Update without password
        $stmt = $conn->prepare("UPDATE Users SET username = ?, email = ? WHERE username = ?");
        $stmt->bind_param("sss", $new_username, $new_email, $username);
    }
    return $stmt->execute();
}

// Check if user is logged in and fetch user data
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $user = getUserData($conn, $username);
    
    if ($user) {
        $email = $user['email'];
        $hashed_password = $user['password'];
        $profile_picture = !empty($user['picture']) ? 'uploads/' . $user['picture'] : $default_image;
    } 
    else {
        $error_message = "User not found.";
    }
} 
else {
    header("Location: login.php");
    exit();
}

// Handle form submission for updating user data
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $new_username = $_POST['username'];
    $new_email = $_POST['email'];
    $new_password = $_POST['psw'];
    $confirm_password = $_POST['psw-repeat'];

    // Initialize response array
    $response = ['success' => false, 'message' => ''];

    // Check if password needs to be updated
    if (!empty($new_password)) {
        // Validate passwords match
        if ($new_password !== $confirm_password) {
            $response['success'] = false;
            $response['message'] = "Passwords do not match.";
        } 
        else {
            // Hash the new password
            $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);
            
            // Update with new password
            if (updateUser($conn, $username, $new_username, $new_email, $hashed_new_password)) {
                $response['success'] = true;
                $response['message'] = "Profile updated successfully with new password.";
                $_SESSION['username'] = $new_username;
                $response['new_username'] = $new_username;
                $response['new_email'] = $new_email;
            } 
            else {
                $response['success'] = false;
                $response['message'] = "Error updating profile with new password.";
            }
        }
    } 
    else {
        // Update without changing password
        if (updateUser($conn, $username, $new_username, $new_email)) {
            $response['success'] = true;
            $response['message'] = "Profile updated successfully.";
            $_SESSION['username'] = $new_username;
            $response['new_username'] = $new_username;
            $response['new_email'] = $new_email;
        } 
        else {
            $response['success'] = false;
            $response['message'] = "Error updating profile.";
        }
    }

    // Send JSON response
    echo json_encode($response);
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form id="updateForm" method="POST">    
        <article class="profile-article">
            <div class="profile-left">
                <h1 class="form-title">Edit Profile</h1>
                <div class="profile-picture-container">
                    <img id="profile-image" class="profile-picture" 
                        src="<?php echo $user['picture'] === 'images/profile.svg' ? 'images/profile.svg' : 'uploads/' . $user['picture']; ?>" 
                        alt="Profile Picture"/>
                        
                    <div class="picture-upload-container">
                        <input type="file" name="picture" id="picture" accept="image/*" class="profile-picture-input">
                        <button type="button" id="uploadPicture" class="upload-btn">Upload Picture</button>
                    </div>
                </div>

                <div class="profile-actions">
                    <a id="cancelbtn" href="home.php">Cancel</a>
                    <button type="submit" class="formbtn" name="update">
                        <img src="images\editProfile.svg" alt="edit">
                        Save
                    </button>
                </div>
            </div>
            <div class="profile-right">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" value="<?php echo $username ?>" required><br>
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="<?php echo $email ?>" required><br>
                <label for="psw">New Password</label>
                <input type="password" name="psw" id="psw" placeholder="New Password"><br>
                <label for="psw-repeat">Confirm New Password</label>
                <input type="password" name="psw-repeat" id="psw-repeat" placeholder="Confirm New Password"><br>
                <p id="form-error-message"><?php echo !empty($error_message) ? $error_message : ''; ?></p>
                <p id="form-success-message"><?php echo !empty($success_message) ? $success_message : ''; ?></p>
            </div>
        </article>
    </form>
    <script src="script.js"></script>
    <script src="profile.js"></script>
</body>
</html> 