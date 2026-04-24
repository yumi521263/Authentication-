<?php
session_start();

if(!isset($_SESSION['loggedin'])){
    header("Location: login.php");
    exit();
}

// Set a default username if not set
if(!isset($_SESSION['username'])) {
    $_SESSION['username'] = "User";
}

// Display messages from 2FA setup
$success_msg = "";
$error_msg = "";

if(isset($_GET['msg']) && !empty($_GET['msg'])) {
    $success_msg = htmlspecialchars($_GET['msg']);
}
if(isset($_GET['error']) && !empty($_GET['error'])) {
    $error_msg = htmlspecialchars($_GET['error']);
}

// Get current 2FA status
include "connection.php";
$twofaEnabled = false;
if(isset($_SESSION['user_id'])) {
    $stmt = $conn->prepare("SELECT twofa_enabled FROM users WHERE id = ?");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    if($row = $result->fetch_assoc()) {
        $twofaEnabled = ($row['twofa_enabled'] == 1);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .welcome-container {
            text-align: center;
        }
        .logout-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #ff4757;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .logout-btn:hover {
            background-color: #ff6b81;
        }
        .message-success {
            background: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 5px;
            margin: 10px 0;
            text-align: center;
        }
        .message-error {
            background: #ffe0e0;
            color: #ff0000;
            padding: 10px;
            border-radius: 5px;
            margin: 10px 0;
            text-align: center;
        }
        .twofa-section {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
            margin: 20px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }
        .twofa-status {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .twofa-enabled {
            color: #28a745;
            font-weight: bold;
        }
        .twofa-disabled {
            color: #dc3545;
            font-weight: bold;
        }
        .btn-2fa {
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        .btn-enable {
            background-color: #28a745;
            color: white;
        }
        .btn-enable:hover {
            background-color: #218838;
        }
        .btn-disable {
            background-color: #dc3545;
            color: white;
        }
        .btn-disable:hover {
            background-color: #c82333;
        }
        .tip-text {
            font-size: 12px;
            color: #666;
            margin-top: -10px;
            margin-bottom: 15px;
            text-align: left;
        }
        .dashboard-card {
            background: rgba(255,255,255,0.95);
            border-radius: 15px;
            padding: 20px;
            margin: 20px 0;
            text-align: left;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }
    </style>
</head>
<body>

<div class="container welcome-container">
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>! 🎉</h2>
    <p>Email: <?php echo htmlspecialchars($_SESSION['email']); ?></p>
    <p>You have successfully logged in.</p>
    
    <?php if($success_msg): ?>
        <div class="message-success"><?php echo $success_msg; ?></div>
    <?php endif; ?>
    
    <?php if($error_msg): ?>
        <div class="message-error"><?php echo $error_msg; ?></div>
    <?php endif; ?>
    
    <div class="dashboard-card">
        <h3>📊 Dashboard</h3>
        <p>Welcome to your secure dashboard. Manage your account security below.</p>
    </div>
    
    <div class="twofa-section">
        <div class="twofa-status">
            <strong>🔐 Two-Factor Authentication</strong>
            <span>Status: 
                <?php if($twofaEnabled): ?>
                    <span class="twofa-enabled">✓ Enabled</span>
                <?php else: ?>
                    <span class="twofa-disabled">✗ Disabled</span>
                <?php endif; ?>
            </span>
        </div>
        <div>
            <form method="POST" action="setup_2fa.php">
                <?php if($twofaEnabled): ?>
                    <button type="submit" name="disable_2fa" class="btn-2fa btn-disable">Disable 2FA</button>
                <?php else: ?>
                    <button type="submit" name="enable_2fa" class="btn-2fa btn-enable">Enable 2FA</button>
                <?php endif; ?>
            </form>
        </div>
    </div>
    
    <?php if(!$twofaEnabled): ?>
        <div class="tip-text">
            💡 <strong>Security Tip:</strong> Enable Two-Factor Authentication to add an extra layer of security to your account. 
            When enabled, you'll need to enter a verification code from your authenticator app after logging in.
        </div>
    <?php else: ?>
        <div class="tip-text">
            ✅ <strong>Great!</strong> Your account is protected with Two-Factor Authentication. Each login will require a verification code.
        </div>
    <?php endif; ?>
    
    <a href="logout.php" class="logout-btn">Logout</a>
</div>

</body>
</html>