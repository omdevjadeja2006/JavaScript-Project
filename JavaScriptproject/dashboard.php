<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: Login.html");
    exit();
}

include 'db_connect.php';

$current_user_id = $_SESSION['user_id'];
$current_username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>TaskFlow - My Tasks</title>
    <link rel="stylesheet" href="dashboard.css">
    <link rel="icon" type="image/x-icon" href="images/download.jpg">
</head>
<body>
    <div class="page-wrapper">   
        <div class="header">   
            <h1 class="logo">TaskFlow</h1>
            <nav class="nav-container">
                <span style="color: white; margin-right: 20px;">Welcome, <?php echo htmlspecialchars($current_username); ?>!</span>
                <a href="homepage.php" class="na">Home</a>
                <a href="logout.php" class="na">Logout</a>
            </nav>
        </div>

        <div class="main-container">  
            <div class="dashboard-box landing-anim"> 
                <h2 id="heading">Your Task Board</h2>
                
                <form action="add_task.php" method="POST" class="task-form">
                    <input type="text" name="task_name" class="data" placeholder="What needs to be done?" required>
                    <select name="priority" class="btn-small" style="background: rgba(0,0,0,0.4); color: white; border: 1px solid rgba(255,255,255,0.2); padding: 5px; border-radius: 5px;">
                        <option value="Low" style="color: black;">Low</option>
                        <option value="Medium" style="color: black;">Medium</option>
                        <option value="High" style="color: black;">High</option>
                    </select>
                    <input type="submit" value="Add Task" class="btn-small">
                </form>

                <div class="task-list">
                    <?php
                    $sql = "SELECT * FROM tasks WHERE user_id = '$current_user_id' ORDER BY id DESC";
                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                            $style = ($row['status'] == 1) ? 'style="text-decoration: line-through; opacity: 0.6;"' : '';
                            
                            // Dynamic color coding for Priority
                            $p_color = '#00ca4e'; // Low
                            if($row['priority'] == 'High') $p_color = '#ff5f5f'; // Red
                            if($row['priority'] == 'Medium') $p_color = '#ffbd44'; // Orange
        
                            echo '<div class="task-item">';
                            echo '<div>';
                                echo '<span style="color: '.$p_color.'; font-weight: bold; margin-right: 10px;">['.$row['priority'].']</span>';
                                echo '<span ' . $style . '>' . htmlspecialchars($row['task_name']) . '</span>';
                            echo '</div>';
                            
                            echo '<div class="task-actions">';
                            if($row['status'] == 0) {
                                echo '<a href="update_task.php?id=' . $row['id'] . '" class="na" style="color: #ffffff; margin-right: 15px;">Done</a>';
                            }
                            // Edit link triggers JavaScript prompt
                            echo '<a href="#" onclick="editTask('.$row['id'].', \''.addslashes($row['task_name']).'\')" style="color: #ffbd44; margin-right: 15px; text-decoration: none;">Edit</a>';
                            echo '<a href="delete_task.php?id=' . $row['id'] . '" class="delete-link" style="color: #ff5f5f; font-weight: bold; text-decoration: none;">✕</a>';
                            echo '</div>';
                            echo '</div>';
                        }
                    } else {
                        echo '<p style="color: rgba(255,255,255,0.6); text-align: center;">No tasks yet. Add one above!</p>';
                    }
                    ?>
                </div>
            </div>
        </div>    
    </div>

    <script>
    function editTask(id, currentName) {
        let newName = prompt("Edit your task:", currentName);
        if (newName !== null && newName.trim() !== "") {
            window.location.href = "edit_task.php?id=" + id + "&new_name=" + encodeURIComponent(newName);
        }
    }
    </script>
</body>
</html>