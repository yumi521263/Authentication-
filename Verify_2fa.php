<?php
session_start();
include "connection.php";

// Redirect if no temp session
if(!isset($_SESSION['temp_user_id'])) {
    header("Location: login.php");
    exit();
}

$error = "";

if (isset($_POST['verify'])) {
    $code = $_POST['code'];
    $userId = $_SESSION['temp_user_id'];
    
    // Get user's 2FA secret
    $stmt = $conn->prepare("SELECT twofa_secret, username, email FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    
    // Simple TOTP verification (demo mode)
    // In production, use a proper TOTP library like OTPHP
    if ($code == "123456") {
        $_SESSION['loggedin'] = true;
        $_SESSION['user_id'] = $userId;
        $_SESSION['email'] = $user['email'];
        $_SESSION['username'] = $user['username'];
        
        // Clear temp session
        unset($_SESSION['temp_user_id']);
        unset($_SESSION['temp_email']);
        unset($_SESSION['temp_username']);
        
        header("Location: home.php");
        exit();
    } else {
        $error = "Invalid verification code. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>2FA Verification</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .error {
            background: #ffe0e0;
            color: #ff0000;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            text-align: center;
        }
        .info {
            text-align: center;
            margin-bottom: 20px;
            color: #666;
        }
        .code-input {
            text-align: center;
            font-size: 24px;
            letter-spacing: 5px;
        }
        .demo-note {
            background: #f0f8ff;
            padding: 10px;
            border-radius: 5px;
            margin-top: 15px;
            text-align: center;
            font-size: 12px;
            color: #4a90e2;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>📱 Two-Factor Authentication</h2>
    <div class="info">
        <p>Please enter the 6-digit code from your authenticator app.</p>
    </div>
    
    <?php if($error): ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <form method="POST">
        <input type="text" name="code" placeholder="Enter 6-digit code" maxlength="6" class="code-input" required>
        <button name="verify">Verify & Login</button>
    </form>
    
    <a href="login.php">← Back to Login</a>
    
    <div class="demo-note">
        🔧 Demo Mode: Use code <strong>123456</strong> to verify
    </div>
</div>
</body>
</html>