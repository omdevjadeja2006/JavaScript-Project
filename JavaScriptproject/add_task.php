<?php
session_start();
include 'db_connect.php';

// Check if the form was submitted and the user is logged in
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {
    
    // 1. Capture and sanitize inputs to prevent SQL injection
    $task = mysqli_real_escape_string($conn, $_POST['task_name']);
    $priority = mysqli_real_escape_string($conn, $_POST['priority']); // New priority field
    $user_id = $_SESSION['user_id'];

    // 2. Insert the task with its assigned priority into the database
    // Make sure you ran: ALTER TABLE tasks ADD COLUMN priority VARCHAR(10) DEFAULT 'Low';
    $sql = "INSERT INTO tasks (user_id, task_name, priority) VALUES ('$user_id', '$task', '$priority')";

    if (mysqli_query($conn, $sql)) {
        // 3. Refresh the dashboard to show the new task
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>