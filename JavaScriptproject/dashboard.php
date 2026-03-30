<?php include 'dashboard_logic.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>TaskFlow | The Living Canopy</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@600;700;800&family=Manrope:wght@400;600;700&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<script id="tailwind-config">
    tailwind.config = {
        darkMode: "class",
        theme: {
            extend: {
                colors: {
                    "surface-dim": "#d8dbd8",
                    "on-tertiary": "#ffffff",
                    "on-error-container": "#93000a",
                    "on-secondary": "#ffffff",
                    "inverse-on-surface": "#eff1ee",
                    "on-background": "#191c1b",
                    "surface-container-low": "#f2f4f1",
                    "primary-fixed": "#bcf0ae",
                    "tertiary-fixed-dim": "#a9c7ff",
                    "secondary": "#805533",
                    "surface-container-high": "#e7e9e6",
                    "inverse-surface": "#2e312f",
                    "surface-container-highest": "#e1e3e0",
                    "surface-container-lowest": "#ffffff",
                    "on-secondary-fixed": "#301400",
                    "tertiary-container": "#124f97",
                    "outline-variant": "#c2c9bb",
                    "surface-container": "#eceeeb",
                    "secondary-container": "#fdc39a",
                    "on-secondary-container": "#794e2e",
                    "surface": "#f8faf7",
                    "background": "#f8faf7",
                    "surface-variant": "#e1e3e0",
                    "error-container": "#ffdad6",
                    "outline": "#72796e",
                    "primary-fixed-dim": "#a1d494",
                    "on-secondary-fixed-variant": "#653d1e",
                    "error": "#ba1a1a",
                    "secondary-fixed": "#ffdcc5",
                    "primary-container": "#2d5a27",
                    "on-primary-container": "#9dd090",
                    "on-tertiary-fixed-variant": "#00468c",
                    "surface-bright": "#f8faf7",
                    "on-error": "#ffffff",
                    "on-surface": "#191c1b",
                    "on-primary-fixed-variant": "#23501e",
                    "on-primary": "#ffffff",
                    "inverse-primary": "#a1d494",
                    "surface-tint": "#3b6934",
                    "tertiary-fixed": "#d6e3ff",
                    "on-tertiary-fixed": "#001b3d",
                    "primary": "#154212",
                    "on-tertiary-container": "#a2c3ff",
                    "on-surface-variant": "#42493e",
                    "secondary-fixed-dim": "#f4bb92",
                    "on-primary-fixed": "#002201",
                    "tertiary": "#003872"
                },
                fontFamily: {
                    "headline": ["Plus Jakarta Sans"],
                    "body": ["Manrope"],
                    "label": ["Manrope"]
                },
                borderRadius: { "DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px" },
            },
        },
    }
</script>
<style>
    /* ── LOGO AUTO PULSE (repeats every 3s) ── */
    @keyframes logoPulse {
        0%,100% { opacity:1; transform: scale(1); }
        50%      { opacity:0.75; transform: scale(1.04); }
    }
    .logo-pulse { animation: logoPulse 3s ease-in-out infinite; }

    /* ── STAT CARD HOVER LIFT ── */
    .stat-card {
        transition: transform 0.35s cubic-bezier(0.34,1.56,0.64,1),
                    box-shadow 0.35s ease;
        cursor: default;
    }
    .stat-card:hover {
        transform: translateY(-6px) scale(1.03);
        box-shadow: 0 16px 40px rgba(21,66,18,0.14);
    }

    /* Hide scrollbar */
    html { scrollbar-width: none; -ms-overflow-style: none; }
    html::-webkit-scrollbar { display: none; }

    /* DASHBOARD BACKGROUND IMAGE */
    .dashboard-bg {
        position: fixed; inset: 0; z-index: -1;
        background-image: url('https://images.unsplash.com/photo-1448375240586-882707db888b?w=1600&q=80&auto=format&fit=crop');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        opacity: 0.07;
        pointer-events: none;
    }

    /* GREETING ANIMATIONS */
    @keyframes greetFadeUp {
        from { opacity: 0; transform: translateY(24px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes greetNamePop {
        from { opacity: 0; transform: translateY(20px) scale(0.95); }
        to   { opacity: 1; transform: translateY(0) scale(1); }
    }
    @keyframes greetSubtitle {
        from { opacity: 0; transform: translateX(-12px); }
        to   { opacity: 1; transform: translateX(0); }
    }
    @keyframes statCardIn {
        from { opacity: 0; transform: translateY(18px) scale(0.97); }
        to   { opacity: 1; transform: translateY(0) scale(1); }
    }

    .anim-greeting   { animation: greetFadeUp   0.65s cubic-bezier(0.34,1.56,0.64,1) 0.1s  both; }
    .anim-name       { display: inline-block; animation: greetNamePop  0.7s  cubic-bezier(0.34,1.56,0.64,1) 0.3s  both; }
    .anim-subtitle   { animation: greetSubtitle 0.55s ease 0.5s both; }
    .anim-stat-1     { animation: statCardIn 0.5s cubic-bezier(0.34,1.56,0.64,1) 0.15s both; }
    .anim-stat-2     { animation: statCardIn 0.5s cubic-bezier(0.34,1.56,0.64,1) 0.27s both; }
    .anim-stat-3     { animation: statCardIn 0.5s cubic-bezier(0.34,1.56,0.64,1) 0.39s both; }
    .anim-stat-4     { animation: statCardIn 0.5s cubic-bezier(0.34,1.56,0.64,1) 0.51s both; }

    .material-symbols-outlined {
        font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
    }
    .leaf-shape { border-radius: 1.5rem 0.75rem 1.5rem 0.75rem; }
    .backdrop-blur-xl { backdrop-filter: blur(24px); }
    .leaf-vein-overlay {
        background-image: url("data:image/svg+xml,%3Csvg width='200' height='200' viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M100 0 C120 40 180 60 200 100 C180 140 120 160 100 200 C80 160 20 140 0 100 C20 60 80 40 100 0' fill='none' stroke='%23154212' stroke-width='0.5' stroke-opacity='0.03'/%3E%3C/svg%3E");
    }
    .lively-button {
        transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1), opacity 0.2s ease;
    }
    .lively-button:hover  { transform: scale(1.05); }
    .lively-button:active { transform: scale(0.95); opacity: 0.85; }
    .status-overdue   { border-left-color: #ba1a1a !important; background: #fff8f7 !important; }
    .status-due-today { border-left-color: #ff6d00 !important; background: #fff8f0 !important; }
    .status-due-soon  { border-left-color: #e6ac00 !important; background: #fffbf0 !important; }
    .badge-overdue   { background:#ffdad6; color:#ba1a1a; }
    .badge-due-today { background:#ffe0b2; color:#bf360c; }
    .badge-due-soon  { background:#fff9c4; color:#827717; }
    .badge-ok        { background:#e8f5e9; color:#1b5e20; }
    .badge-none      { background:#eceeeb; color:#42493e; }
    @keyframes pulse-red { 0%,100%{opacity:1} 50%{opacity:.55} }
    .pulse-red { animation: pulse-red 1.4s ease-in-out infinite; }
    #edit-modal { transition: opacity .25s ease; }
    #edit-modal.hidden { opacity:0; pointer-events:none; }
    #edit-modal:not(.hidden) { opacity:1; }
    #flash-toast { transition: opacity .4s ease, transform .4s ease; }
    .task-completed h3 { text-decoration: line-through; opacity: .55; }
</style>
</head>
<body class="bg-background text-on-background font-body selection:bg-secondary-container selection:text-on-secondary-container leaf-vein-overlay min-h-screen">
<div class="dashboard-bg"></div>

<?php
$flash_messages = [
    'task_updated' => ['check_circle', '#bcf0ae', 'Task updated successfully.'],
    'all_done'     => ['done_all',    '#bcf0ae', 'All tasks marked as done!'],
    'all_clear'    => ['delete_sweep','#ffb4ab', 'All tasks cleared.'],
];
if ($flash && isset($flash_messages[$flash])):
    [$fi, $fc, $ft] = $flash_messages[$flash];
?>
<div id="flash-toast" class="fixed top-6 left-1/2 -translate-x-1/2 z-[200] bg-gray-900 text-white text-sm font-semibold px-6 py-3 rounded-full shadow-xl flex items-center gap-2">
    <span class="material-symbols-outlined text-base" style="color:<?php echo $fc;?>"><?php echo $fi;?></span>
    <?php echo $ft; ?>
</div>
<script>setTimeout(()=>{const t=document.getElementById('flash-toast');if(t){t.style.opacity='0';t.style.transform='translateY(-8px) translateX(-50%)';setTimeout(()=>t.remove(),400);}},2500);</script>
<?php endif; ?>

<!-- ── Edit Task Modal ── -->
<div id="edit-modal" class="hidden fixed inset-0 z-[100] flex items-center justify-center bg-black/40 backdrop-blur-sm">
    <div class="bg-white rounded-[2rem] shadow-2xl p-10 w-full max-w-lg relative">
        <button onclick="closeEditModal()" class="absolute top-5 right-5 text-outline hover:text-error transition-colors">
            <span class="material-symbols-outlined">close</span>
        </button>
        <h2 class="text-2xl font-bold text-primary font-headline mb-1">Edit Task</h2>
        <p class="text-sm text-on-surface-variant mb-8">Update the details of your task below.</p>
        <form id="edit-form" action="edit_task.php" method="POST" class="space-y-5">
            <input type="hidden" name="id" id="edit-id"/>
            <div>
                <label class="block text-xs font-bold uppercase tracking-widest text-primary mb-1.5">Task Name</label>
                <input type="text" name="task_name" id="edit-name" required
                    class="w-full bg-surface-container-highest border-none rounded-xl py-4 px-5 focus:ring-2 focus:ring-primary/30 text-on-surface font-semibold placeholder:text-outline/50"
                    placeholder="What needs to be done?"/>
            </div>
            <div>
                <label class="block text-xs font-bold uppercase tracking-widest text-primary mb-1.5">Priority</label>
                <select name="priority" id="edit-priority"
                    class="w-full bg-surface-container-highest border-none rounded-xl py-4 px-5 focus:ring-2 focus:ring-primary/30 text-on-surface font-semibold">
                    <option value="Low">🌱 Low</option>
                    <option value="Medium">🌿 Medium</option>
                    <option value="High">🔥 High</option>
                </select>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-widest text-primary mb-1.5">Due Date</label>
                    <input type="date" name="due_date" id="edit-due-date"
                        class="w-full bg-surface-container-highest border-none rounded-xl py-4 px-5 focus:ring-2 focus:ring-primary/30 text-on-surface font-semibold"/>
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-widest text-primary mb-1.5">Due Time</label>
                    <input type="time" name="due_time" id="edit-due-time"
                        class="w-full bg-surface-container-highest border-none rounded-xl py-4 px-5 focus:ring-2 focus:ring-primary/30 text-on-surface font-semibold"/>
                </div>
            </div>
            <label class="flex items-center gap-3 cursor-pointer text-sm text-on-surface-variant font-medium">
                <input type="checkbox" name="clear_due" id="edit-clear-due" value="1"
                    class="h-4 w-4 rounded border-outline-variant text-primary focus:ring-primary/20"/>
                Clear due date &amp; time
            </label>
            <button type="submit"
                class="w-full bg-primary text-on-primary py-4 rounded-xl font-bold text-base lively-button shadow-lg shadow-primary/20 mt-2">
                Save Changes
            </button>
        </form>
    </div>
</div>

<!-- ── Top Nav ── -->
<nav class="fixed top-0 left-0 right-0 z-50 bg-[#f8faf7]">
    <div class="flex justify-between items-center w-full px-8 py-4 max-w-7xl mx-auto">
        <div class="logo-pulse text-2xl font-bold text-[#154212] tracking-tighter font-headline">TaskFlow</div>
        <div class="hidden md:flex items-center gap-8">
            <a class="font-headline font-bold text-sm tracking-tight text-[#154212] border-b-2 border-[#154212] pb-1" href="dashboard.php">My Tasks</a>
            <a class="font-headline font-bold text-sm tracking-tight text-[#5c635e] pb-1 hover:text-[#154212] transition-colors duration-300" href="index.php">Home</a>
        </div>
        <div class="flex items-center gap-4">
            <span class="text-sm font-semibold text-on-surface-variant"><?php echo htmlspecialchars($current_username); ?></span>
            <a href="logout.php" class="text-[#154212] p-2 rounded-full hover:bg-surface-container transition-colors" title="Logout">
                <span class="material-symbols-outlined">logout</span>
            </a>
        </div>
    </div>
</nav>

<!-- ── Side Nav ── -->
<aside class="fixed left-0 top-0 h-full w-64 flex flex-col p-6 z-40 bg-[#f2f4f1]/70 backdrop-blur-xl rounded-r-[2rem] pt-24">
    <div class="logo-pulse flex items-center gap-3 mb-10 px-4">
        <div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center text-on-primary">
            <span class="material-symbols-outlined text-sm" style="font-variation-settings:'FILL' 1;">nest_eco_leaf</span>
        </div>
        <div>
            <h2 class="text-xl font-bold text-[#154212] font-headline">TaskFlow</h2>
            <p class="text-[10px] uppercase tracking-widest text-outline font-bold">The Living Canopy</p>
        </div>
    </div>
    <nav class="flex flex-col gap-2 flex-grow">
        <a class="bg-[#fdc39a] text-[#794e2e] rounded-full px-4 py-2 flex items-center gap-3 font-semibold text-sm lively-button" href="dashboard.php">
            <span class="material-symbols-outlined" style="font-variation-settings:'FILL' 1;">potted_plant</span>
            Overview
        </a>
        <a class="text-[#5c635e] px-4 py-2 flex items-center gap-3 font-semibold text-sm hover:bg-[#e4e9e2] rounded-full transition-all duration-300" href="index.php">
            <span class="material-symbols-outlined">home</span>
            Home
        </a>
        <a class="text-[#5c635e] px-4 py-2 flex items-center gap-3 font-semibold text-sm hover:bg-[#e4e9e2] rounded-full transition-all duration-300" href="logout.php">
            <span class="material-symbols-outlined">logout</span>
            Logout
        </a>
    </nav>
    <div class="flex flex-col gap-2 mb-3">
        <form action="bulk_done.php" method="POST" onsubmit="return confirm('Mark ALL active tasks as done?')">
            <button type="submit" class="w-full bg-[#e8f5e9] text-[#1b5e20] rounded-xl py-2.5 px-4 font-bold text-sm flex items-center justify-center gap-2 hover:bg-[#c8e6c9] transition-all lively-button">
                <span class="material-symbols-outlined text-base">done_all</span>
                Mark All Done
            </button>
        </form>
        <form action="bulk_clear.php" method="POST" onsubmit="return confirm('Permanently delete ALL tasks? This cannot be undone.')">
            <button type="submit" class="w-full bg-[#ffdad6] text-[#ba1a1a] rounded-xl py-2.5 px-4 font-bold text-sm flex items-center justify-center gap-2 hover:bg-[#ffb4ab] transition-all lively-button">
                <span class="material-symbols-outlined text-base">delete_sweep</span>
                Clear All Tasks
            </button>
        </form>
    </div>
    <button onclick="document.getElementById('task-input').focus()"
        class="mb-8 bg-primary text-on-primary rounded-xl py-3 px-4 font-bold flex items-center justify-center gap-2 lively-button shadow-lg shadow-primary/20">
        <span class="material-symbols-outlined">add</span>
        Add New Task
    </button>
    <div class="flex flex-col gap-2 pt-6 border-t border-outline-variant/10">
        <div class="text-[#5c635e] px-4 py-2 flex items-center gap-3 text-sm">
            <span class="material-symbols-outlined">monitoring</span>
            <?php echo $completed; ?> / <?php echo $total; ?> tasks done
        </div>
    </div>
</aside>

<!-- ── Main Content ── -->
<main class="ml-64 pt-24 px-12 pb-12">
<div class="max-w-5xl mx-auto">

    <!-- Hero Greeting -->
    <header class="mb-12">
        <h1 class="anim-greeting text-[3.5rem] font-bold text-primary leading-tight font-headline tracking-tight mb-2">
            <?php echo $greeting; ?>, <span class="anim-name text-secondary"><?php echo htmlspecialchars($current_username); ?></span>.
        </h1>
        <p class="anim-subtitle text-on-surface-variant text-lg max-w-2xl">
            <?php if ($total === 0): ?>
                Your canopy is empty. Plant your first task below.
            <?php elseif ($active === 0): ?>
                All tasks complete — your ecosystem is in full bloom! 🌿
            <?php else: ?>
                You have <strong><?php echo $active; ?></strong> active task<?php echo $active !== 1 ? 's' : ''; ?> ready for growth today.
            <?php endif; ?>
        </p>
    </header>

    <div class="grid grid-cols-12 gap-8">

        <!-- ── Main Task Card ── -->
        <section class="col-span-12 lg:col-span-8 bg-surface-container-lowest leaf-shape p-8 shadow-[0_20px_40px_rgba(25,28,27,0.06)] relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-primary/5 rounded-full -mr-16 -mt-16 blur-3xl"></div>
            <div class="flex justify-between items-center mb-10">
                <h2 class="text-2xl font-semibold text-primary font-headline">My Tasks</h2>
                <span class="px-4 py-1.5 rounded-full bg-tertiary-fixed text-on-tertiary-fixed font-bold text-[10px] tracking-wider uppercase">
                    <?php echo $active; ?> Active
                </span>
            </div>

            <!-- ── Add Task Form ── -->
            <form action="add_task.php" method="POST" class="mb-10">
                <div class="relative flex items-center mb-3">
                    <input id="task-input" type="text" name="task_name" required
                        class="w-full bg-surface-container-highest border-none rounded-xl py-5 pl-14 pr-36 focus:ring-2 focus:ring-tertiary-container transition-all duration-300 placeholder:text-outline/60 text-on-surface font-semibold"
                        placeholder="What will you grow today?"/>
                    <span class="material-symbols-outlined absolute left-5 text-primary opacity-60">eco</span>
                    <button type="submit" class="absolute right-3 bg-primary text-on-primary px-6 py-2.5 rounded-lg font-bold text-sm lively-button">
                        Add Task
                    </button>
                </div>
                <div class="flex flex-wrap gap-3 mt-3">
                    <select name="priority" class="bg-surface-container-highest border-none rounded-xl py-2.5 px-4 text-sm font-semibold text-on-surface focus:ring-2 focus:ring-primary/20">
                        <option value="Low">🌱 Low Priority</option>
                        <option value="Medium">🌿 Medium Priority</option>
                        <option value="High">🔥 High Priority</option>
                    </select>
                    <input type="date" name="due_date"
                        class="bg-surface-container-highest border-none rounded-xl py-2.5 px-4 text-sm font-semibold text-on-surface focus:ring-2 focus:ring-primary/20"
                        title="Due Date (optional)"/>
                    <input type="time" name="due_time"
                        class="bg-surface-container-highest border-none rounded-xl py-2.5 px-4 text-sm font-semibold text-on-surface focus:ring-2 focus:ring-primary/20"
                        title="Due Time (optional)"/>
                </div>
            </form>

            <!-- ── Task List ── -->
            <div class="space-y-4">
            <?php if (empty($tasks)): ?>
                <div class="text-center py-16 text-on-surface-variant">
                    <span class="material-symbols-outlined text-5xl opacity-30 block mb-3">eco</span>
                    <p class="font-semibold">No tasks yet. Plant your first seed above.</p>
                </div>
            <?php else: ?>
                <?php foreach ($tasks as $task):
                    $due_status = getDueStatus($task['due_date'] ?? '', $task['due_time'] ?? '');
                    $is_done    = ($task['status'] == 1);

                    $border_cls = match($task['priority']) {
                        'High'   => 'border-[#ba1a1a]',
                        'Medium' => 'border-secondary',
                        default  => 'border-primary',
                    };

                    $row_cls = 'group flex items-center justify-between p-5 bg-surface-container-low leaf-shape hover:bg-surface-container transition-all duration-300 border-l-4 ' . $border_cls;
                    if (!$is_done && $due_status) $row_cls .= ' status-' . $due_status;
                    if ($is_done) $row_cls .= ' task-completed opacity-70';

                    $due_label = '';
                    if (!empty($task['due_date'])) {
                        $due_label = date('M j', strtotime($task['due_date']));
                        if (!empty($task['due_time'])) $due_label .= ' · ' . date('g:i A', strtotime($task['due_time']));
                    }

                    $p_badge = match($task['priority']) {
                        'High'   => '<span class="px-3 py-1 text-[10px] font-bold rounded-full" style="background:#ffdad6;color:#ba1a1a;">🔥 HIGH</span>',
                        'Medium' => '<span class="px-3 py-1 text-[10px] font-bold rounded-full bg-secondary-container text-on-secondary-container">🌿 MED</span>',
                        default  => '<span class="px-3 py-1 text-[10px] font-bold rounded-full bg-primary-fixed text-on-primary-fixed">🌱 LOW</span>',
                    };

                    $status_badge = '';
                    if (!$is_done && $due_label) {
                        $badge_cls = match($due_status) {
                            'overdue'   => 'badge-overdue pulse-red',
                            'due-today' => 'badge-due-today',
                            'due-soon'  => 'badge-due-soon',
                            default     => 'badge-ok',
                        };
                        $status_icon = match($due_status) {
                            'overdue'   => '⚠️',
                            'due-today' => '🕐',
                            'due-soon'  => '⏳',
                            default     => '📅',
                        };
                        $status_badge = "<span class=\"px-3 py-1 text-[10px] font-bold rounded-full $badge_cls\">$status_icon $due_label</span>";
                    }
                ?>
                <div class="<?php echo $row_cls; ?>">
                    <div class="flex items-center gap-4 flex-1 min-w-0">
                        <?php if (!$is_done): ?>
                        <a href="update_task.php?id=<?php echo $task['id']; ?>"
                            class="w-6 h-6 rounded-full border-2 border-outline-variant flex items-center justify-center hover:border-primary transition-colors flex-shrink-0"
                            title="Mark as done">
                            <div class="w-3 h-3 rounded-full bg-primary scale-0 group-hover:scale-50 transition-transform"></div>
                        </a>
                        <?php else: ?>
                        <div class="w-6 h-6 rounded-full bg-primary flex items-center justify-center flex-shrink-0">
                            <span class="material-symbols-outlined text-on-primary text-xs" style="font-variation-settings:'FILL' 1;">check</span>
                        </div>
                        <?php endif; ?>
                        <div class="min-w-0">
                            <h3 class="font-bold text-on-surface text-base truncate"><?php echo htmlspecialchars($task['task_name']); ?></h3>
                            <div class="flex flex-wrap gap-1.5 mt-1.5">
                                <?php echo $p_badge; ?>
                                <?php echo $status_badge; ?>
                                <?php if ($is_done): ?>
                                <span class="px-3 py-1 text-[10px] font-bold rounded-full bg-primary-fixed text-on-primary-fixed">✅ Done</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 ml-3 flex-shrink-0">
                        <button onclick="openEditModal(
                            <?php echo $task['id']; ?>,
                            '<?php echo addslashes(htmlspecialchars($task['task_name'])); ?>',
                            '<?php echo $task['priority']; ?>',
                            '<?php echo $task['due_date'] ?? ''; ?>',
                            '<?php echo $task['due_time'] ?? ''; ?>'
                        )" class="p-2 text-outline hover:text-primary transition-colors opacity-0 group-hover:opacity-100 lively-button" title="Edit task">
                            <span class="material-symbols-outlined text-xl">edit</span>
                        </button>
                        <a href="delete_task.php?id=<?php echo $task['id']; ?>"
                            onclick="return confirm('Remove this task from your canopy?')"
                            class="p-2 text-outline hover:text-error transition-colors opacity-0 group-hover:opacity-100 lively-button"
                            title="Delete task">
                            <span class="material-symbols-outlined text-xl">delete</span>
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
            </div>

            <button onclick="document.getElementById('task-input').focus(); document.getElementById('task-input').scrollIntoView({behavior:'smooth'});"
                class="w-full mt-8 py-4 border-2 border-dashed border-outline-variant rounded-xl text-outline font-bold text-sm hover:border-primary hover:text-primary transition-all flex items-center justify-center gap-2">
                <span class="material-symbols-outlined text-sm">add_circle</span>
                Add Another Task
            </button>
        </section>

        <!-- ── Right Sidebar Stats ── -->
        <aside class="col-span-12 lg:col-span-4 space-y-5">

            <!-- Completion Progress Card -->
            <div class="bg-primary bg-gradient-to-br from-primary to-primary-container p-7 rounded-[2rem] text-on-primary shadow-xl shadow-primary/20">
                <div class="flex justify-between items-start mb-5">
                    <div>
                        <h3 class="text-on-primary-container text-[10px] font-bold uppercase tracking-widest mb-1">Completion</h3>
                        <p class="text-3xl font-bold font-headline"><?php echo $bloom_pct; ?>%</p>
                        <p class="text-on-primary-container text-xs mt-0.5"><?php echo $completed; ?> of <?php echo $total; ?> tasks done</p>
                    </div>
                    <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center">
                        <span class="material-symbols-outlined text-2xl" style="font-variation-settings:'FILL' 1;">donut_large</span>
                    </div>
                </div>
                <div class="h-2.5 w-full bg-white/20 rounded-full overflow-hidden mb-3">
                    <div class="h-full bg-[#bcf0ae] rounded-full shadow-[0_0_12px_rgba(188,240,174,0.6)] transition-all duration-700"
                        style="width:<?php echo $bloom_pct; ?>%"></div>
                </div>
                <?php if ($active > 0): ?>
                <div class="flex gap-1 mt-2" title="Priority breakdown of active tasks">
                    <?php if($high_count):   ?><div class="h-1.5 rounded-full bg-[#ffb4ab]" style="flex:<?php echo $high_count;?>" title="<?php echo $high_count;?> High"></div><?php endif; ?>
                    <?php if($medium_count): ?><div class="h-1.5 rounded-full bg-[#ffd180]" style="flex:<?php echo $medium_count;?>" title="<?php echo $medium_count;?> Medium"></div><?php endif; ?>
                    <?php if($low_count):    ?><div class="h-1.5 rounded-full bg-[#bcf0ae]" style="flex:<?php echo $low_count;?>" title="<?php echo $low_count;?> Low"></div><?php endif; ?>
                </div>
                <p class="text-[10px] text-on-primary-container mt-1.5 opacity-70">
                    <?php echo $high_count; ?> high · <?php echo $medium_count; ?> medium · <?php echo $low_count; ?> low priority
                </p>
                <?php endif; ?>
            </div>

            <!-- 4-stat grid -->
            <div class="grid grid-cols-2 gap-4">
                <div class="anim-stat-1 stat-card bg-surface-container-lowest rounded-[1.5rem] p-5 shadow-sm border border-outline-variant/20">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="material-symbols-outlined text-lg text-primary" style="font-variation-settings:'FILL' 1;">pending_actions</span>
                        <span class="text-[10px] font-bold uppercase tracking-widest text-outline">Active</span>
                    </div>
                    <p class="text-2xl font-bold text-primary font-headline"><?php echo $active; ?></p>
                    <p class="text-xs text-on-surface-variant mt-0.5">tasks remaining</p>
                </div>
                <div class="anim-stat-2 stat-card bg-surface-container-lowest rounded-[1.5rem] p-5 shadow-sm border border-outline-variant/20">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="material-symbols-outlined text-lg text-secondary" style="font-variation-settings:'FILL' 1;">schedule</span>
                        <span class="text-[10px] font-bold uppercase tracking-widest text-outline">Est. Time</span>
                    </div>
                    <p class="text-2xl font-bold text-secondary font-headline"><?php echo $est_label; ?></p>
                    <p class="text-xs text-on-surface-variant mt-0.5">to finish all</p>
                </div>
                <div class="anim-stat-3 stat-card bg-surface-container-lowest rounded-[1.5rem] p-5 shadow-sm border <?php echo $overdue_count>0 ? 'border-[#ba1a1a]/30 bg-[#fff8f7]' : 'border-outline-variant/20'; ?>">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="material-symbols-outlined text-lg <?php echo $overdue_count>0 ? 'text-[#ba1a1a]' : 'text-outline'; ?>" style="font-variation-settings:'FILL' 1;">warning</span>
                        <span class="text-[10px] font-bold uppercase tracking-widest text-outline">Overdue</span>
                    </div>
                    <p class="text-2xl font-bold font-headline <?php echo $overdue_count>0 ? 'text-[#ba1a1a]' : 'text-on-surface'; ?>"><?php echo $overdue_count; ?></p>
                    <p class="text-xs text-on-surface-variant mt-0.5">need attention</p>
                </div>
                <div class="anim-stat-4 stat-card bg-surface-container-lowest rounded-[1.5rem] p-5 shadow-sm border border-outline-variant/20">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="material-symbols-outlined text-lg text-tertiary" style="font-variation-settings:'FILL' 1;">event_upcoming</span>
                        <span class="text-[10px] font-bold uppercase tracking-widest text-outline">Next Due</span>
                    </div>
                    <p class="text-xl font-bold text-tertiary font-headline leading-tight"><?php echo $nearest_due_label; ?></p>
                    <p class="text-xs text-on-surface-variant mt-0.5">closest deadline</p>
                </div>
            </div>

            <!-- Priority breakdown bar card -->
            <?php if ($active > 0): ?>
            <div class="bg-surface-container-lowest rounded-[2rem] p-6 shadow-sm border border-outline-variant/20">
                <h4 class="text-primary font-bold text-sm mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-base">bar_chart</span>
                    Priority Breakdown
                </h4>
                <div class="space-y-3">
                    <?php
                    $bars = [
                        ['🔥 High',   $high_count,   '#ba1a1a', '#ffdad6'],
                        ['🌿 Medium', $medium_count, '#805533', '#fdc39a'],
                        ['🌱 Low',    $low_count,    '#154212', '#bcf0ae'],
                    ];
                    foreach ($bars as [$label, $count, $color, $bg]):
                        $pct = $active > 0 ? round(($count/$active)*100) : 0;
                    ?>
                    <div>
                        <div class="flex justify-between text-xs font-semibold mb-1" style="color:<?php echo $color;?>">
                            <span><?php echo $label; ?></span>
                            <span><?php echo $count; ?> task<?php echo $count!==1?'s':''; ?></span>
                        </div>
                        <div class="h-2 w-full rounded-full" style="background:<?php echo $bg;?>40">
                            <div class="h-2 rounded-full transition-all duration-700" style="width:<?php echo $pct;?>%;background:<?php echo $color;?>"></div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- Completed tasks card -->
            <div class="bg-surface-container-high rounded-[2rem] p-6">
                <h4 class="text-primary font-bold text-sm mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-base" style="font-variation-settings:'FILL' 1;">task_alt</span>
                    Completed
                </h4>
                <?php if ($completed === 0): ?>
                    <p class="text-xs text-on-surface-variant">No tasks completed yet. Keep going!</p>
                <?php else: ?>
                <div class="space-y-2 max-h-40 overflow-y-auto pr-1">
                    <?php foreach (array_filter($tasks, fn($t) => $t['status']==1) as $t): ?>
                    <div class="flex items-center gap-2 text-xs text-on-surface-variant">
                        <span class="material-symbols-outlined text-sm text-primary" style="font-variation-settings:'FILL' 1;">check_circle</span>
                        <span class="line-through truncate"><?php echo htmlspecialchars($t['task_name']); ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>

        </aside>
    </div>
</div>
</main>

<!-- FAB -->
<button onclick="document.getElementById('task-input').focus(); document.getElementById('task-input').scrollIntoView({behavior:'smooth'});"
    class="fixed bottom-10 right-10 w-16 h-16 bg-secondary text-on-secondary rounded-[1.5rem] shadow-2xl flex items-center justify-center lively-button group z-50"
    title="Add new task">
    <span class="material-symbols-outlined text-3xl transition-transform group-hover:rotate-90" style="font-variation-settings:'wght' 600;">add</span>
</button>

<script>
function openEditModal(id, name, priority, dueDate, dueTime) {
    document.getElementById('edit-id').value       = id;
    document.getElementById('edit-name').value     = name;
    document.getElementById('edit-priority').value = priority;
    document.getElementById('edit-due-date').value = dueDate;
    document.getElementById('edit-due-time').value = dueTime;
    document.getElementById('edit-clear-due').checked = false;
    document.getElementById('edit-modal').classList.remove('hidden');
}
function closeEditModal() {
    document.getElementById('edit-modal').classList.add('hidden');
}
document.getElementById('edit-modal').addEventListener('click', function(e) {
    if (e.target === this) closeEditModal();
});
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeEditModal();
});
</script>
</body>
</html>