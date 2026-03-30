<?php
session_start();
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {

    $id      = mysqli_real_escape_string($conn, $_POST['id']);
    $name    = mysqli_real_escape_string($conn, $_POST['task_name']);
    $priority= mysqli_real_escape_string($conn, $_POST['priority']);
    $user_id = $_SESSION['user_id'];

    // Validate priority value (whitelist)
    if (!in_array($priority, ['Low', 'Medium', 'High'])) $priority = 'Low';

    // Handle "clear due date" checkbox
    if (!empty($_POST['clear_due'])) {
        $due_date_val = "NULL";
        $due_time_val = "NULL";
    } else {
        $due_date = !empty($_POST['due_date']) ? mysqli_real_escape_string($conn, $_POST['due_date']) : NULL;
        $due_time = !empty($_POST['due_time']) ? mysqli_real_escape_string($conn, $_POST['due_time']) : NULL;
        $due_date_val = $due_date ? "'$due_date'" : "NULL";
        $due_time_val = $due_time ? "'$due_time'" : "NULL";
    }

    $sql = "UPDATE tasks
            SET task_name = '$name',
                priority  = '$priority',
                due_date  = $due_date_val,
                due_time  = $due_time_val
            WHERE id = '$id' AND user_id = '$user_id'";

    if (mysqli_query($conn, $sql)) {
        header("Location: dashboard.php?edited=1");
        exit();
    } else {
        echo "Error updating task: " . mysqli_error($conn);
    }

} else {
    // Not a POST or not logged in → back to dashboard
    header("Location: dashboard.php");
    exit();
}
?>