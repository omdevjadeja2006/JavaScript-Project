<?php
// ============================================================
//  homepage_logic.php — All business logic for index.php
//  Included at the top of index.php via: include 'homepage_logic.php'
// ============================================================

session_start();
$logged_in = isset($_SESSION['user_id']);
$username  = $logged_in ? htmlspecialchars($_SESSION['username']) : '';

// ── Fetch real task stats only if logged in ──
$bloom_pct    = 0;
$done_count   = 0;
$total_count  = 0;
$active_count = 0;

if ($logged_in) {
    include 'db_connect.php';
    $uid = $_SESSION['user_id'];
    $res = mysqli_query($conn, "SELECT status FROM tasks WHERE user_id = '$uid'");
    while ($row = mysqli_fetch_assoc($res)) {
        $total_count++;
        if ($row['status'] == 1) $done_count++;
    }
    $active_count = $total_count - $done_count;
    $bloom_pct    = $total_count > 0 ? round(($done_count / $total_count) * 100) : 0;
}