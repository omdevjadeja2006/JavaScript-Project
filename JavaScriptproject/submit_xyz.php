<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $confirm_pass = $_POST['confirm_password'];

    // 1. Check if passwords match
    if ($pass !== $confirm_pass) {
        die("Passwords do not match!");
    }

    // 2. Hash the password for security (Requires the 255 length you set)
    $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);

    // 3. Insert into your 'users' table
    $sql = "INSERT INTO users (username, email, password) VALUES ('$user', '$email', '$hashed_pass')";

    if (mysqli_query($conn, $sql)) {
        // Redirect to login page after success
        header("Location: Login.html");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>