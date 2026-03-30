<?php
// ============================================================
//  dashboard_logic.php — All business logic for dashboard.php
//  Included at the top of dashboard.php via: include 'dashboard_logic.php'
// ============================================================

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: Login.html");
    exit();
}
include 'db_connect.php';

$current_user_id  = $_SESSION['user_id'];
$current_username = $_SESSION['username'];

// ── Time-based greeting ──
$hour = (int)date('G');
if ($hour < 12)      $greeting = "Good morning";
elseif ($hour < 17)  $greeting = "Good afternoon";
else                  $greeting = "Good evening";

// ── Fetch tasks ──
$result = mysqli_query($conn, "SELECT * FROM tasks WHERE user_id = '$current_user_id' ORDER BY id DESC");
$tasks  = [];
while ($row = mysqli_fetch_assoc($result)) {
    $tasks[] = $row;
}

// ── Stats ──
$total     = count($tasks);
$completed = count(array_filter($tasks, fn($t) => $t['status'] == 1));
$active    = $total - $completed;
$bloom_pct = $total > 0 ? round(($completed / $total) * 100) : 0;

// ── Priority breakdown (active tasks only) ──
$high_count   = count(array_filter($tasks, fn($t) => $t['status'] == 0 && $t['priority'] === 'High'));
$medium_count = count(array_filter($tasks, fn($t) => $t['status'] == 0 && $t['priority'] === 'Medium'));
$low_count    = count(array_filter($tasks, fn($t) => $t['status'] == 0 && $t['priority'] === 'Low'));

// ── Estimated time to complete ──
// Heuristic: High = 45 min, Medium = 25 min, Low = 15 min
$est_minutes = ($high_count * 45) + ($medium_count * 25) + ($low_count * 15);
$est_hours   = floor($est_minutes / 60);
$est_mins_r  = $est_minutes % 60;
if ($active === 0)        $est_label = '—';
elseif ($est_hours > 0)   $est_label = $est_hours . 'h ' . ($est_mins_r > 0 ? $est_mins_r . 'm' : '');
else                       $est_label = $est_mins_r . 'm';

// ── Nearest upcoming deadline ──
$nearest_due       = null;
$nearest_due_label = '—';
foreach ($tasks as $t) {
    if ($t['status'] == 1 || empty($t['due_date'])) continue;
    $ts = strtotime($t['due_date'] . (!empty($t['due_time']) ? ' ' . $t['due_time'] : ' 23:59:59'));
    if ($ts > time() && ($nearest_due === null || $ts < $nearest_due)) {
        $nearest_due = $ts;
    }
}
if ($nearest_due) {
    $diff = $nearest_due - time();
    $d    = floor($diff / 86400);
    $h    = floor(($diff % 86400) / 3600);
    $m    = floor(($diff % 3600) / 60);
    if ($d > 0)      $nearest_due_label = "in {$d}d {$h}h";
    elseif ($h > 0)  $nearest_due_label = "in {$h}h {$m}m";
    else              $nearest_due_label = "in {$m}m";
}

// ── Streak label ──
$streak_label = $completed > 0 ? $completed . ' done' : 'None yet';

// ── Due date status helper ──
// Returns one of: 'overdue' | 'due-today' | 'due-soon' | 'ok' | ''
function getDueStatus($due_date, $due_time) {
    if (empty($due_date)) return '';
    $due_str  = $due_date . (!empty($due_time) ? ' ' . $due_time : ' 23:59:59');
    $due_ts   = strtotime($due_str);
    $now      = time();
    $diff_hrs = ($due_ts - $now) / 3600;
    if ($diff_hrs < 0)   return 'overdue';
    if ($diff_hrs < 1)   return 'due-today';
    if ($diff_hrs < 24)  return 'due-soon';
    return 'ok';
}

// ── Overdue count ──
$overdue_tasks = array_filter($tasks, fn($t) => $t['status'] == 0 && getDueStatus($t['due_date'] ?? '', $t['due_time'] ?? '') === 'overdue');
$overdue_count = count($overdue_tasks);

// ── Flash message after edit / bulk actions ──
$flash = '';
if (isset($_GET['edited']))    $flash = 'task_updated';
if (isset($_GET['all_done']))  $flash = 'all_done';
if (isset($_GET['all_clear'])) $flash = 'all_clear';
