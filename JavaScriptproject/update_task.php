<?php
session_start();
include 'db_connect.php';

if (isset($_GET['id']) && isset($_SESSION['user_id'])) {
    $task_id = mysqli_real_escape_string($conn, $_GET['id']);
    $user_id = $_SESSION['user_id'];

    // Update status to 1 (Completed)
    $sql = "UPDATE tasks SET status = 1 WHERE id = '$task_id' AND user_id = '$user_id'";

    if (mysqli_query($conn, $sql)) {
        header("Location: dashboard.php");
        exit();
    }
}
?>