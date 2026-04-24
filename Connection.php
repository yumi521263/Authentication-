<?php $host = "localhost";
$username = "root"; 
$password = "";
$dbname = "auth_db";
$conn = new mysqli($host, $username, $password, $dbname); 
if ($conn->connect_error) { 
  die("DB connection failed: " . $conn->connect_error); 
}
?>