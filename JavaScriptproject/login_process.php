<?php
session_start();
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Capture and sanitize inputs
    $user = mysqli_real_escape_string($conn, $_POST['username']);
    $pass = $_POST['password'];

    // 2. Look up the user by username
    $sql = "SELECT id, username, password FROM users WHERE username = '$user'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 0) {
        // No user found with that username
        header("Location: Login.html?nouser=1");
        exit();
    }

    $row = mysqli_fetch_assoc($result);

    // 3. Verify the password against the stored hash
    if (!password_verify($pass, $row['password'])) {
        // Wrong password
        header("Location: Login.html?wrongpass=1");
        exit();
    }

    // 4. Credentials are correct — start the session
    $_SESSION['user_id']  = $row['id'];
    $_SESSION['username'] = $row['username'];

    header("Location: dashboard.php");
    exit();
}
?>