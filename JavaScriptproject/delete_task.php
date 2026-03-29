<?php
session_start();
include 'db_connect.php';

if (isset($_GET['id']) && isset($_SESSION['user_id'])) {
    $task_id = mysqli_real_escape_string($conn, $_GET['id']);
    $user_id = $_SESSION['user_id'];

    // Security: Only delete if the task belongs to the logged-in user
    $sql = "DELETE FROM tasks WHERE id = '$task_id' AND user_id = '$user_id'";

    if (mysqli_query($conn, $sql)) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error deleting task: " . mysqli_error($conn);
    }
}
?>