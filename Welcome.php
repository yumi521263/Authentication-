
<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Welcome to AuthSystem</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .hero {
            text-align: center;
            max-width: 800px;
        }
        .hero h1 {
            font-size: 3em;
            margin-bottom: 20px;
            background: linear-gradient(135deg, #4a90e2, #357abd);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        .hero p {
            font-size: 1.2em;
            color: #555;
            margin-bottom: 30px;
        }
        .features {
            display: flex;
            gap: 20px;
            justify-content: center;
            margin: 40px 0;
            flex-wrap: wrap;
        }
        .feature-card {
            background: rgba(255,255,255,0.9);
            padding: 20px;
            border-radius: 15px;
            width: 200px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .feature-card .icon {
            font-size: 40px;
            margin-bottom: 10px;
        }
        .btn-group {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 20px;
        }
        .btn {
            padding: 12px 30px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        .btn-primary {
            background: #4a90e2;
            color: white;
        }
        .btn-primary:hover {
            background: #357abd;
            transform: translateY(-2px);
        }
        .btn-secondary {
            background: transparent;
            color: #4a90e2;
            border: 2px solid #4a90e2;
        }
        .btn-secondary:hover {
            background: #4a90e2;
            color: white;
        }
    </style>
</head>
<body>
<div class="container hero">
    <h1>🔐 Secure AuthSystem</h1>
    <p>Modern authentication with Two-Factor Authentication (2FA) for maximum security</p>
    
    <div class="features">
        <div class="feature-card">
            <div class="icon">🛡️</div>
            <h3>2FA Security</h3>
            <p>Optional two-factor authentication using Google Authenticator</p>
        </div>
        <div class="feature-card">
            <div class="icon">⚡</div>
            <h3>Fast & Simple</h3>
            <p>Clean interface with smooth animations</p>
        </div>
        <div class="feature-card">
            <div class="icon">🔒</div>
            <h3>Secure</h3>
            <p>Password hashing and secure session management</p>
        </div>
    </div>
    
    <div class="btn-group">
        <a href="login.php" class="btn btn-primary">Login</a>
        <a href="signup.php" class="btn btn-secondary">Sign Up</a>
    </div>
</div>
</body>
</html>