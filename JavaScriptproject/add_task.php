<?php
session_start();
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {

    $task     = mysqli_real_escape_string($conn, $_POST['task_name']);
    $priority = mysqli_real_escape_string($conn, $_POST['priority']);
    $user_id  = $_SESSION['user_id'];

    // Due date and time (optional — empty string if not provided)
    $due_date = !empty($_POST['due_date']) ? mysqli_real_escape_string($conn, $_POST['due_date']) : NULL;
    $due_time = !empty($_POST['due_time']) ? mysqli_real_escape_string($conn, $_POST['due_time']) : NULL;

    // Use NULL for empty values so the DB stores NULL, not an empty string
    $due_date_val = $due_date ? "'$due_date'" : "NULL";
    $due_time_val = $due_time ? "'$due_time'" : "NULL";

    /*
     * ── DB MIGRATION REQUIRED ──
     * Run these once in phpMyAdmin / MySQL before using this file:
     *
     *   ALTER TABLE tasks ADD COLUMN priority VARCHAR(10)  NOT NULL DEFAULT 'Low';
     *   ALTER TABLE tasks ADD COLUMN due_date DATE         DEFAULT NULL;
     *   ALTER TABLE tasks ADD COLUMN due_time TIME         DEFAULT NULL;
     *
     * If the columns already exist, skip those lines.
     */
    $sql = "INSERT INTO tasks (user_id, task_name, priority, due_date, due_time)
            VALUES ('$user_id', '$task', '$priority', $due_date_val, $due_time_val)";

    if (mysqli_query($conn, $sql)) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error adding task: " . mysqli_error($conn);
    }
}
?>