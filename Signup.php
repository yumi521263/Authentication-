<?php
include "connection.php";

if (isset($_POST['signup'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username,email,password) VALUES ('$username','$email','$password')";
    mysqli_query($conn, $sql);

    header("Location: login.php");
}
?>

<link rel="stylesheet" href="style.css">

<div class="container">
<h2>Signup</h2>

<form method="POST">
    <input type="text" name="username" placeholder="Username">
    <input type="email" name="email" placeholder="Email">
    <input type="password" name="password" placeholder="Password">
    <button name="signup">Signup</button>
</form>

<a href="login.php">Already have account?</a>
</div>