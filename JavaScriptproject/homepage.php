<?php
session_start();
// No automatic redirect, allowing users to see the landing page
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaskFlow - Welcome</title>
    <link rel="stylesheet" href="homepage2.css">
    <link rel="icon" type="image/x-icon" href="images/download (1).png">
</head>
<body>
    <div class="header">  
        <h1 class="logo">TaskFlow</h1>
        <nav class="nav-container">
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="dashboard.php" class="support-link">Go to Dashboard</a>
            <?php endif; ?>
            <a href="contact.html" class="support-link">Support</a>
        </nav>
    </div>

    <div class="content welcome-box">
        <div class="hero-text">
            <h1>Manage your tasks with ease.</h1>
            <p>Organize your university projects and daily goals in one place.</p>
        </div>

        <div class="action-section"> 
            <?php if (!isset($_SESSION['user_id'])): ?>
                <div class="action-card">
                    <h3>Returning User?</h3><br><br>
                    <a href="Login.html"><button class="main-btn">Log-in Now</button></a>
                </div>
                <div class="divider"></div>
                <div class="action-card">
                    <h3>New here?</h3>
                    <p>Create an account to start tracking tasks.</p><br>
                    <a href="signin.html"><button class="secondary-btn">Sign-in (Register)</button></a>
                </div>
            <?php else: ?>
                <div class="action-card" style="width: 100%; text-align: center;">
                    <h3>Welcome back, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h3>
                    <p>You are already logged in. Ready to check your tasks?</p><br>
                    <a href="dashboard.php"><button class="main-btn">Open My Task Board</button></a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="footer">
        <p>&copy; 2026 Task Management System</p>
    </div>
</body>
</html>