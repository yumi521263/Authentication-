<?php
session_start();
include "connection.php";

if(!isset($_SESSION['loggedin'])){
    header("Location: login.php");
    exit();
}

$message = "";
$error = "";

// Enable 2FA
if(isset($_POST['enable_2fa'])) {
    $userId = $_SESSION['user_id'];
    $update = "UPDATE users SET twofa_enabled = 1 WHERE id = $userId";
    if($conn->query($update)) {
        $message = "Two-factor authentication has been enabled successfully!";
    } else {
        $error = "Failed to enable 2FA. Please try again.";
    }
    header("Location: home.php?msg=" . urlencode($message) . "&error=" . urlencode($error));
    exit();
}

// Disable 2FA
if(isset($_POST['disable_2fa'])) {
    $userId = $_SESSION['user_id'];
    $update = "UPDATE users SET twofa_enabled = 0, twofa_secret = NULL WHERE id = $userId";
    if($conn->query($update)) {
        $message = "Two-factor authentication has been disabled.";
    } else {
        $error = "Failed to disable 2FA. Please try again.";
    }
    header("Location: home.php?msg=" . urlencode($message) . "&error=" . urlencode($error));
    exit();
}

// If accessed directly, redirect to home
header("Location: home.php");
exit();
?>