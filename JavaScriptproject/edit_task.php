<?php
session_start();
include 'db_connect.php';
if (isset($_GET['id']) && isset($_GET['new_name'])) {
    $id = $_GET['id'];
    $name = mysqli_real_escape_string($conn, $_GET['new_name']);
    $user_id = $_SESSION['user_id'];
    mysqli_query($conn, "UPDATE tasks SET task_name = '$name' WHERE id = '$id' AND user_id = '$user_id'");
    header("Location: dashboard.php");
}
?>