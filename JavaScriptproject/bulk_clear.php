<?php
session_start();
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Permanently delete ALL tasks for this user
    $sql = "DELETE FROM tasks WHERE user_id = '$user_id'";

    if (mysqli_query($conn, $sql)) {
        header("Location: dashboard.php?all_clear=1");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    header("Location: dashboard.php");
    exit();
}
?>