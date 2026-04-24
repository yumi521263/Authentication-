<?php
session_start();
include "connection.php";

if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    // Use prepared statement for security
    $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        
        if (password_verify($password, $user['password'])) {
            // Store in temp session for 2FA check
            $_SESSION['temp_user_id'] = $user['id'];
            $_SESSION['temp_email'] = $email;
            $_SESSION['temp_username'] = $user['username'];
            $_SESSION['temp_twofa_enabled'] = isset($user['twofa_enabled']) ? $user['twofa_enabled'] : 0;
            
            // Check if 2FA is enabled for this user
            if(isset($user['twofa_enabled']) && $user['twofa_enabled'] == 1) {
                // Redirect to 2FA verification
                header("Location: verify_2fa.php");
                exit();
            } else {
                // Direct login without 2FA
                $_SESSION['loggedin'] = true;
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['email'] = $email;
                $_SESSION['username'] = $user['username'];
                
                header("Location: home.php");
                exit();
            }
        } else {
            echo "Invalid email or password";
        }
    } else {
        echo "Invalid email or password";
    }
}
?>

<link rel="stylesheet" href="style.css">

<div class="container">
<h2>Login</h2>

<form method="POST">
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button name="login">Login</button>
</form>

<a href="signup.php">Don't have account? Signup</a>
</div>