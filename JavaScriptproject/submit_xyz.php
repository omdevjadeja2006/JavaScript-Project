<?php
session_start();
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 1. Capture and sanitize inputs
    $user         = mysqli_real_escape_string($conn, trim($_POST['username']));
    $email        = mysqli_real_escape_string($conn, trim($_POST['email']));
    $pass         = $_POST['password'];
    $confirm_pass = $_POST['confirm_password'];

    // ── 2. Validate email format ──
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: signin.html?error=invalidemail");
        exit();
    }

    // ── 3. Validate email domain actually exists (MX or A record check) ──
    $email_domain = substr(strrchr($email, "@"), 1);
    if (!checkdnsrr($email_domain, "MX") && !checkdnsrr($email_domain, "A")) {
        header("Location: signin.html?error=fakedomain");
        exit();
    }

    // ── 4. Check if passwords match ──
    if ($pass !== $confirm_pass) {
        header("Location: signin.html?error=passmatch");
        exit();
    }

    // ── 5. Check if EMAIL already exists (separate error) ──
    $email_check = mysqli_query($conn, "SELECT id FROM users WHERE email = '$email'");
    if (mysqli_num_rows($email_check) > 0) {
        header("Location: signin.html?error=emailexists");
        exit();
    }

    // ── 6. Check if USERNAME already exists (separate error) ──
    $user_check = mysqli_query($conn, "SELECT id FROM users WHERE username = '$user'");
    if (mysqli_num_rows($user_check) > 0) {
        header("Location: signin.html?error=userexists");
        exit();
    }

    // ── 7. Hash the password securely ──
    $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);

    // ── 8. Insert the new user ──
    $sql = "INSERT INTO users (username, email, password) VALUES ('$user', '$email', '$hashed_pass')";

    if (mysqli_query($conn, $sql)) {
        header("Location: Login.html?success=registered");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>