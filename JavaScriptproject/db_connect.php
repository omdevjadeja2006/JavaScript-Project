<?php
$host = "localhost";
$user = "root"; // Default XAMPP user
$pass = "";     // Default XAMPP password is empty
$dbname = "javascript project"; // Your database name from the screenshot

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>