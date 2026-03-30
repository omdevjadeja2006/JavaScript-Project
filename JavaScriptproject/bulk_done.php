<?php
session_start();
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Mark all active (status=0) tasks for this user as done (status=1)
    $sql = "UPDATE tasks SET status = 1 WHERE user_id = '$user_id' AND status = 0";

    if (mysqli_query($conn, $sql)) {
        header("Location: dashboard.php?all_done=1");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    header("Location: dashboard.php");
    exit();
}
?>