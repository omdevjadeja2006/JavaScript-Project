<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Capture and sanitize inputs
    $user = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = $_POST['password'];
    $confirm_pass = $_POST['confirm_password'];

    // 2. Check if passwords match
    if ($pass !== $confirm_pass) {
        // Redirect back to signin.html with a password mismatch error
        header("Location: signin.html?error=passmatch");
        exit();
    }

    // 3. Check if email or username already exists in the 'users' table
    $check_sql = "SELECT id FROM users WHERE email = '$email' OR username = '$user'";
    $check_result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {
        // Redirect back to signin.html with an 'exists' error
        header("Location: signin.html?error=exists");
        exit();
    }

    // 4. Hash the password for security
    $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);

    // 5. Insert the new user into the database
    $sql = "INSERT INTO users (username, email, password) VALUES ('$user', '$email', '$hashed_pass')";

    if (mysqli_query($conn, $sql)) {
        // Redirect to login page after successful registration
        header("Location: Login.html?success=registered");
        exit();
    } else {
        // Standard error reporting if the query fails for other reasons
        echo "Error: " . mysqli_error($conn);
    }
}
?>