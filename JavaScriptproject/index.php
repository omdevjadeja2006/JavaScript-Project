<?php include 'homepage_logic.php'; // renamed from homepage.php ?>
<!DOCTYPE html>
<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Be+Vietnam+Pro:wght@300;400;500;600&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<script id="tailwind-config">
tailwind.config = {
  darkMode: "class",
  theme: {
    extend: {
      colors: {
        "surface-variant": "#deddd8","error-dim": "#b92902","surface-container-highest": "#deddd8",
        "surface-container-lowest": "#ffffff","secondary-dim": "#8c3220","on-tertiary-fixed": "#003d4f",
        "on-tertiary-container": "#005267","tertiary": "#04647d","outline-variant": "#aeadaa",
        "secondary": "#9c3d2a","surface-bright": "#f8f6f2","on-background": "#2e2f2d",
        "on-primary-container": "#2d5a27","surface-tint": "#386631","primary-fixed-dim": "#abdf9e",
        "on-secondary-fixed-variant": "#8d3321","on-tertiary": "#e3f6ff","surface-dim": "#d5d4d0",
        "on-secondary-fixed": "#661607","tertiary-fixed-dim": "#8cd3f0","primary-fixed": "#b9eeab",
        "surface-container": "#e9e8e4","on-primary-fixed-variant": "#376430","on-surface-variant": "#5b5c59",
        "inverse-primary": "#b9eeab","on-tertiary-fixed-variant": "#005c74","primary-dim": "#2d5927",
        "on-error-container": "#520c00","tertiary-dim": "#00576e","on-primary": "#d2ffc4",
        "on-surface": "#2e2f2d","surface-container-low": "#f2f1ec","error-container": "#f95630",
        "secondary-fixed": "#ffc4b8","surface-container-high": "#e4e2de","primary-container": "#b9eeab",
        "error": "#b02500","on-secondary-container": "#812a19","tertiary-fixed": "#9ae1ff",
        "on-primary-fixed": "#1a4716","outline": "#777774","secondary-fixed-dim": "#ffb0a0",
        "secondary-container": "#ffc4b8","background": "#f8f6f2","primary": "#386631",
        "tertiary-container": "#9ae1ff","inverse-on-surface": "#9e9d99","on-secondary": "#ffefec",
        "on-error": "#ffefec","inverse-surface": "#0e0e0d","surface": "#f8f6f2"
      },
      fontFamily: { "headline": ["Plus Jakarta Sans"], "body": ["Be Vietnam Pro"], "label": ["Be Vietnam Pro"] },
      borderRadius: {"DEFAULT": "1rem", "lg": "2rem", "xl": "3rem", "full": "9999px"},
    },
  },
}
</script>
<style>
  /* 1. HIDE SCROLLBAR */
  html { scrollbar-width: none; -ms-overflow-style: none; }
  html::-webkit-scrollbar { display: none; }

  .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
  .bg-mesh-gradient {
    background-color: #f8f6f2;
    background-image:
      radial-gradient(at 0% 0%, rgba(56,102,49,0.05) 0px, transparent 50%),
      radial-gradient(at 100% 0%, rgba(4,100,125,0.05) 0px, transparent 50%),
      radial-gradient(at 100% 100%, rgba(156,61,42,0.03) 0px, transparent 50%);
  }
  .leaf-texture {
    mask-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M30 5c-5 10-15 15-25 15 10 5 15 15 15 25 5-10 15-15 25-15-10-5-15-15-15-25z' fill='%23000' fill-opacity='0.1'/%3E%3C/svg%3E");
    mask-repeat: repeat;
  }

  /* 3. CARD ENTRANCE ANIMATIONS */
  @keyframes cardEntrance {
    from { opacity: 0; transform: translateY(28px) scale(0.97); }
    to   { opacity: 1; transform: translateY(0) scale(1); }
  }
  .card-animate-1 { animation: cardEntrance 0.6s cubic-bezier(0.34,1.56,0.64,1) 0.15s both; }
  .card-animate-2 { animation: cardEntrance 0.6s cubic-bezier(0.34,1.56,0.64,1) 0.32s both; }

  /* Card hover lift + glow */
  .action-card {
    transition: transform 0.4s cubic-bezier(0.34,1.56,0.64,1), box-shadow 0.4s ease, background-color 0.3s ease;
  }
  .action-card:hover { transform: translateY(-6px) scale(1.01); box-shadow: 0 24px 56px rgba(56,102,49,0.13); }

  /* Icon bounce on card hover */
  .action-card:hover .card-icon { animation: iconBounce 0.5s cubic-bezier(0.34,1.56,0.64,1); }
  @keyframes iconBounce {
    0%  { transform: scale(1); }
    45% { transform: scale(1.25) rotate(-6deg); }
    75% { transform: scale(0.95) rotate(3deg); }
    100%{ transform: scale(1) rotate(0); }
  }

  /* Primary button — shimmer sweep */
  .btn-shimmer {
    position: relative; overflow: hidden;
    transition: transform 0.3s cubic-bezier(0.34,1.56,0.64,1), box-shadow 0.3s ease;
  }
  .btn-shimmer::after {
    content: ""; position: absolute; inset: 0;
    background: linear-gradient(110deg, transparent 30%, rgba(255,255,255,0.22) 50%, transparent 70%);
    transform: translateX(-100%); transition: transform 0.55s ease;
  }
  .btn-shimmer:hover::after { transform: translateX(100%); }
  .btn-shimmer:hover { transform: scale(1.04); box-shadow: 0 12px 32px rgba(56,102,49,0.28); }
  .btn-shimmer:active { transform: scale(0.97); }

  /* Secondary / outline button */
  .btn-outline-pop {
    transition: transform 0.3s cubic-bezier(0.34,1.56,0.64,1), box-shadow 0.3s ease, background-color 0.3s ease;
  }
  .btn-outline-pop:hover { transform: scale(1.04); background-color: #ffffff; box-shadow: 0 8px 24px rgba(56,102,49,0.12); }
  .btn-outline-pop:active { transform: scale(0.97); }

  /* 2. UNIVERSITY CARD — floating icon */
  @keyframes floatIcon {
    0%,100% { transform: translateY(0); }
    50%      { transform: translateY(-8px); }
  }
  .icon-float { animation: floatIcon 3s ease-in-out infinite; }

  /* Spinning glow ring */
  .glow-ring {
    position: absolute; inset: -6px; border-radius: 50%;
    background: conic-gradient(from 0deg, rgba(255,255,255,0.15), rgba(255,255,255,0.04), rgba(255,255,255,0.15));
    animation: spinRing 8s linear infinite;
  }
  @keyframes spinRing { to { transform: rotate(360deg); } }

  /* ── BADGE + HEADLINE AUTO PULSE (repeats every 3s) ── */
  @keyframes logoPulse {
    0%,100% { opacity:1; transform: scale(1); }
    50%      { opacity:0.78; transform: scale(1.03); }
  }
  .logo-pulse { animation: logoPulse 3s ease-in-out infinite; }

  /* ── PROGRESS CARD HOVER LIFT ── */
  .progress-hover {
    transition: transform 0.35s cubic-bezier(0.34,1.56,0.64,1), box-shadow 0.35s ease;
  }
  .progress-hover:hover {
    transform: translateY(-5px) scale(1.02);
    box-shadow: 0 14px 36px rgba(56,102,49,0.14);
  }

  /* HERO TEXT ANIMATIONS */
  @keyframes fadeSlideUp {
    from { opacity: 0; transform: translateY(22px); }
    to   { opacity: 1; transform: translateY(0); }
  }
  @keyframes fadeSlideDown {
    from { opacity: 0; transform: translateY(-14px); }
    to   { opacity: 1; transform: translateY(0); }
  }
  @keyframes revealWidth {
    from { clip-path: inset(0 100% 0 0); }
    to   { clip-path: inset(0 0% 0 0); }
  }
  @keyframes progressGrow {
    from { opacity: 0; transform: translateY(16px) scale(0.98); }
    to   { opacity: 1; transform: translateY(0) scale(1); }
  }
  .anim-badge    { animation: fadeSlideDown 0.55s cubic-bezier(0.34,1.56,0.64,1) 0.1s both; }
  .anim-h1-line1 { animation: fadeSlideUp  0.65s cubic-bezier(0.34,1.56,0.64,1) 0.25s both; }
  .anim-h1-line2 { display: inline-block; animation: revealWidth 0.7s cubic-bezier(0.77,0,0.18,1) 0.6s both; }
  .anim-subtitle { animation: fadeSlideUp  0.6s ease 0.75s both; }
  .anim-progress { animation: progressGrow 0.6s cubic-bezier(0.34,1.56,0.64,1) 0.95s both; }

  /* Stat pills inside the tertiary card */
  .stat-pill {
    display: inline-flex; align-items: center; gap: 6px;
    background: rgba(255,255,255,0.13); backdrop-filter: blur(6px);
    border: 1px solid rgba(255,255,255,0.2); border-radius: 9999px;
    padding: 6px 14px; font-size: 11px; font-weight: 700;
    color: #e3f6ff; letter-spacing: 0.04em;
  }
</style>
</head>
<body class="bg-mesh-gradient font-body text-on-surface min-h-screen selection:bg-primary-container selection:text-on-primary-container">

<!-- Top Navigation Bar -->
<nav class="fixed top-0 w-full z-50 bg-[#f8f6f2]/70 backdrop-blur-xl">
<div class="flex justify-between items-center px-8 py-4 max-w-7xl mx-auto">
<div class="text-2xl font-bold text-[#386631] tracking-tighter font-headline">TaskFlow</div>
<div class="hidden md:flex items-center gap-8">
<a class="text-[#2e2f2d]/60 font-semibold font-headline hover:text-[#386631] transition-colors duration-300" href="#">Support</a>
<?php if ($logged_in): ?>
    <span class="text-sm font-semibold text-[#386631]">Hi, <?php echo $username; ?></span>
    <a href="logout.php" class="text-[#2e2f2d]/60 font-semibold font-headline hover:text-[#386631] transition-colors duration-300">Logout</a>
    <a href="dashboard.php"><button class="bg-[#386631] text-[#d2ffc4] px-6 py-2 rounded-full font-headline font-semibold scale-95 active:scale-90 transition-transform duration-200">Go to Dashboard</button></a>
<?php else: ?>
    <a href="Login.html"><button class="bg-[#386631] text-[#d2ffc4] px-6 py-2 rounded-full font-headline font-semibold scale-95 active:scale-90 transition-transform duration-200">Log In</button></a>
<?php endif; ?>
</div>
</div>
</nav>

<!-- Hero Section -->
<main class="pt-32 pb-20 px-6 max-w-7xl mx-auto relative overflow-hidden">
<div class="absolute -top-20 -left-20 w-96 h-96 bg-primary/5 rounded-full blur-3xl leaf-texture pointer-events-none"></div>
<div class="absolute -bottom-20 -right-20 w-96 h-96 bg-tertiary/5 rounded-full blur-3xl leaf-texture pointer-events-none"></div>
<div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">

<!-- Hero Content -->
<div class="lg:col-span-7 flex flex-col items-start gap-6">
<div class="anim-badge logo-pulse inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-primary-container text-on-primary-container text-sm font-semibold tracking-wide border border-primary/10">
<span class="material-symbols-outlined text-sm">nature</span>CULTIVATE YOUR FOCUS
</div>
<h1 class="logo-pulse font-headline font-extrabold text-5xl md:text-7xl lg:text-8xl tracking-tight leading-[0.95] text-on-surface">
  <span class="anim-h1-line1 block">Manage your tasks</span>
  <span class="anim-h1-line2 text-primary italic font-medium">with ease.</span>
</h1>
<p class="anim-subtitle text-xl md:text-2xl text-on-surface-variant max-w-xl leading-relaxed">
  Organize your university projects and daily goals in one place. Experience a sanctuary for productivity inspired by the rhythm of nature.
</p>
<div class="progress-hover anim-progress mt-8 flex flex-col gap-3 w-full max-w-md bg-surface-container-low p-6 rounded-lg">
<div class="flex justify-between items-end">
  <span class="text-sm font-bold font-headline uppercase tracking-widest text-primary"><?php echo $logged_in ? 'Your Progress' : 'Daily Progress'; ?></span>
  <span class="text-2xl font-headline font-bold text-on-surface"><?php echo $bloom_pct; ?>%</span>
</div>
<div class="h-3 w-full bg-surface-variant/30 rounded-full overflow-hidden">
  <div class="h-full bg-primary rounded-full transition-all duration-700" style="width:<?php echo $bloom_pct; ?>%"></div>
</div>
<?php if ($logged_in): ?>
  <p class="text-xs text-on-surface-variant italic"><?php echo $done_count; ?> of <?php echo $total_count; ?> tasks completed<?php if ($active_count > 0): ?> · <?php echo $active_count; ?> still active<?php endif; ?></p>
<?php else: ?>
  <p class="text-xs text-on-surface-variant italic">Log in to track your task progress</p>
<?php endif; ?>
</div>
</div>

<!-- Dual-Card Action Section -->
<div class="lg:col-span-5 grid grid-cols-1 gap-6 relative">
<?php if ($logged_in): ?>
  <div class="action-card card-animate-1 group relative bg-surface-container-lowest p-8 rounded-lg shadow-sm border border-outline-variant/10">
    <div class="flex justify-between items-start mb-12">
      <div class="card-icon w-12 h-12 rounded-full bg-primary-container flex items-center justify-center text-primary">
        <span class="material-symbols-outlined" style="font-variation-settings:'FILL' 1;">person</span>
      </div>
      <span class="text-xs font-bold tracking-[0.2em] uppercase text-outline">Welcome Back</span>
    </div>
    <h3 class="text-2xl font-headline font-bold mb-2">Hello, <?php echo $username; ?>!</h3>
    <p class="text-on-surface-variant mb-4 text-sm">You have <strong><?php echo $active_count; ?></strong> active task<?php echo $active_count !== 1 ? 's' : ''; ?> and have completed <strong><?php echo $done_count; ?></strong> so far. Keep it up!</p>
    <div class="flex flex-col gap-3">
      <a href="dashboard.php">
        <button class="btn-shimmer w-full bg-primary text-on-primary py-4 rounded-full font-headline font-bold flex items-center justify-center gap-2 shadow-lg shadow-primary/20">
          Go to Dashboard <span class="material-symbols-outlined text-sm">arrow_forward</span>
        </button>
      </a>
      <a href="logout.php">
        <button class="btn-outline-pop w-full bg-surface-container text-on-surface py-3 rounded-full font-headline font-semibold flex items-center justify-center gap-2 border border-outline-variant/20">
          <span class="material-symbols-outlined text-sm">logout</span>Log Out
        </button>
      </a>
    </div>
  </div>
<?php else: ?>
  <!-- Login Card -->
  <div class="action-card card-animate-1 group relative bg-surface-container-lowest p-8 rounded-lg shadow-sm border border-outline-variant/10">
    <div class="flex justify-between items-start mb-12">
      <div class="card-icon w-12 h-12 rounded-full bg-primary-container flex items-center justify-center text-primary">
        <span class="material-symbols-outlined">login</span>
      </div>
      <span class="text-xs font-bold tracking-[0.2em] uppercase text-outline">Returning User</span>
    </div>
    <h3 class="text-2xl font-headline font-bold mb-2">Returning User?</h3>
    <p class="text-on-surface-variant mb-8 text-sm">Welcome back. Your tasks are waiting for you.</p>
    <a href="Login.html">
      <button class="btn-shimmer w-full bg-primary text-on-primary py-4 rounded-full font-headline font-bold flex items-center justify-center gap-2 shadow-lg shadow-primary/20">
        Log In Now <span class="material-symbols-outlined text-sm">arrow_forward</span>
      </button>
    </a>
  </div>
  <!-- Sign-up Card -->
  <div class="action-card card-animate-2 group relative bg-surface-container p-8 rounded-lg border border-outline-variant/20">
    <div class="flex justify-between items-start mb-12">
      <div class="card-icon w-12 h-12 rounded-full bg-secondary-container flex items-center justify-center text-secondary">
        <span class="material-symbols-outlined">person_add</span>
      </div>
      <span class="text-xs font-bold tracking-[0.2em] uppercase text-outline">New User</span>
    </div>
    <h3 class="text-2xl font-headline font-bold mb-2">New here?</h3>
    <p class="text-on-surface-variant mb-8 text-sm">Create a free account and start managing your tasks and goals today.</p>
    <a href="signin.html">
      <button class="btn-outline-pop w-full bg-surface-container-lowest text-on-surface py-4 rounded-full font-headline font-bold flex items-center justify-center gap-2 border border-outline-variant/20">
        Create Account <span class="material-symbols-outlined text-sm">person_add</span>
      </button>
    </a>
  </div>
<?php endif; ?>

<div class="hidden xl:block absolute -right-16 top-1/2 -translate-y-1/2 w-32 h-64 rounded-full overflow-hidden border-8 border-background">
<img class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBQ_O8QWTfkf07DuGVMvqcM5Kt0_1aloZFPreotiRulbw4JTsOrE_JU4d0Or-K7k5JAcvUDayYdZN7QMdcQr_FfCFlYMptq17gzdVmDYREZha8R4pd4sg-6_hJXROafBGrAz3ITfyGmR60ajkHEbFObGY3oGdSy99dAlpggwvsXrP0g3KoPlBZG7qjmJwZyLLqkl9CgalvATMukv6Bv8-K0KudR7V8XEIMKEdiW-aEiJdApheiqGTf1k7ug1qdAE7712uqlSvM5QwM"/>
</div>
</div>
</div>
</main>

<!-- Features Bento Grid -->
<section class="max-w-7xl mx-auto px-6 py-20">
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

  <!-- Focus in the Wild -->
  <div class="md:col-span-2 bg-surface-container-low rounded-lg p-10 flex flex-col justify-between overflow-hidden relative min-h-[400px]">
  <div class="relative z-10">
  <h4 class="text-3xl font-headline font-bold text-on-surface mb-4">Focus in the Wild</h4>
  <p class="text-on-surface-variant max-w-sm">Our "Deep Root" mode silences notifications and presents a minimalist canvas for your most complex university projects.</p>
  </div>
  <div class="mt-12 flex gap-4 overflow-hidden">
  <div class="bg-white p-4 rounded-lg shadow-sm min-w-[200px] border border-outline-variant/10">
  <div class="w-8 h-8 rounded bg-primary/10 mb-4"></div>
  <div class="h-2 w-3/4 bg-surface-container rounded mb-2"></div>
  <div class="h-2 w-1/2 bg-surface-container rounded"></div>
  </div>
  <div class="bg-white p-4 rounded-lg shadow-sm min-w-[200px] opacity-50 border border-outline-variant/10">
  <div class="w-8 h-8 rounded bg-secondary/10 mb-4"></div>
  <div class="h-2 w-3/4 bg-surface-container rounded mb-2"></div>
  </div>
  </div>
  <img class="absolute right-0 bottom-0 w-1/2 h-full object-cover mix-blend-multiply opacity-20 pointer-events-none" src="https://lh3.googleusercontent.com/aida-public/AB6AXuB1sjcgaPC_lfiyoQfQ0xTOGZUQcw8YyXeTi9uKxej7uRnFWN1VrmbwI1OgR0L7LUm8csRzVUILMr-QMFgmQ4iR-yBnAIbF8KxEhsgLyxyOAdrRrsYV17Y1VhvC1yzIra9tOgW-Vdd7I5tsMBTMelQLpe3etne0B9k98z1ygbRibzogx9nj2ibMvp2niOQiexkn4MX9ZXNAIGe0FGLhFXlamPX9GTmcjgQJRiIF8HuFvVxnS6bVfM2au_4n_63jSdzJC2tkBUB_PdI"/>
  </div>

  <!-- 2. REDESIGNED University Integration Card -->
  <div class="rounded-lg p-8 flex flex-col justify-between overflow-hidden relative min-h-[280px]"
       style="background: linear-gradient(135deg, #04647d 0%, #024f64 60%, #013b4d 100%);">
    <!-- Corner glows -->
    <div class="absolute -top-10 -right-10 w-48 h-48 rounded-full pointer-events-none"
         style="background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%);"></div>
    <div class="absolute bottom-0 left-0 w-32 h-32 rounded-full pointer-events-none"
         style="background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%);"></div>

    <!-- Top badge -->
    <div class="relative z-10">
      <span class="stat-pill">
        <span class="material-symbols-outlined text-xs" style="font-variation-settings:'FILL' 1;">verified</span>
        ACADEMIC SYNC
      </span>
    </div>

    <!-- Floating icon + text -->
    <div class="flex flex-col items-center justify-center flex-1 py-6 relative z-10">
      <div class="relative w-20 h-20 flex items-center justify-center mb-5">
        <div class="glow-ring"></div>
        <div class="w-20 h-20 rounded-full flex items-center justify-center"
             style="background: rgba(255,255,255,0.12); backdrop-filter: blur(8px); border: 1px solid rgba(255,255,255,0.2);">
          <span class="material-symbols-outlined text-4xl icon-float"
                style="color:#e3f6ff; font-variation-settings:'FILL' 1;">school</span>
        </div>
      </div>
      <h4 class="text-2xl font-headline font-bold text-center mb-2" style="color:#e3f6ff;">University Integration</h4>
      <p class="text-sm text-center max-w-[200px] leading-relaxed" style="color:rgba(227,246,255,0.72);">Sync your academic calendars and research deadlines seamlessly.</p>
    </div>

    <!-- Bottom stat pills -->
    <div class="flex gap-2 flex-wrap relative z-10">
      <span class="stat-pill"><span class="material-symbols-outlined text-xs" style="font-variation-settings:'FILL' 1;">calendar_month</span>Calendar Sync</span>
      <span class="stat-pill"><span class="material-symbols-outlined text-xs" style="font-variation-settings:'FILL' 1;">notifications_active</span>Deadline Alerts</span>
    </div>
  </div>

  <!-- Collaborate card -->
  <div class="md:col-span-3 bg-secondary-container rounded-lg p-8 md:p-12 flex flex-col md:flex-row items-center gap-8 border border-secondary/10">
  <div class="flex-1">
  <span class="text-secondary font-bold font-headline uppercase tracking-widest text-xs mb-4 block">Shared Ecosystem</span>
  <h4 class="text-4xl font-headline font-extrabold text-on-secondary-container mb-4">Collaborate like a forest.</h4>
  <p class="text-on-secondary-container/70 max-w-lg mb-6">Group projects shouldn't feel like chaos. Share tasks, files, and updates in a shared digital grove where everyone contributes to the growth.</p>
  <button class="text-secondary font-bold flex items-center gap-2 hover:gap-4 transition-all">
    Explore Team Spaces <span class="material-symbols-outlined">trending_flat</span>
  </button>
  </div>
  <div class="flex-1 w-full max-w-md aspect-video rounded-lg overflow-hidden shadow-2xl">
  <img class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCxlPbhK3itrmG1fqbSqY5mU2tS1h4l6i_3pF1eW83tgA83bNOjistsHgYonUtK6YaoF3O-6ZEFCeFLLhBPgbuvBO-JzstzSL_axrBOoacBfzDgl_AvO-gFv62a1Eb1_ThF2HVKUtQ7BjNp1rUSWX11eHz0rodF4TlIBmUZPFdYnPmJc-hzUNZYBlXM3Gjd-bD9qV_IDoqonl3qiZdqBYPzAKIEekqAbX16HOY763uW1LSJXHNoE_3cIkZFevX8FO1fyV_HDVoddVU"/>
  </div>
  </div>

</div>
</section>

<!-- Footer -->
<footer class="bg-[#e9e8e4] py-12 px-8">
<div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-8">
<div class="flex flex-col items-center md:items-start gap-2">
<div class="font-['Plus_Jakarta_Sans'] font-bold text-[#386631] text-xl">TaskFlow</div>
<p class="text-[#2e2f2d]/50 font-['Be_Vietnam_Pro'] text-sm">© 2026 Task Management System</p>
</div>
<div class="flex gap-8">
<a class="text-[#2e2f2d]/50 hover:text-[#386631] transition-opacity text-sm font-['Be_Vietnam_Pro']" href="#">Privacy Policy</a>
<a class="text-[#2e2f2d]/50 hover:text-[#386631] transition-opacity text-sm font-['Be_Vietnam_Pro']" href="#">Terms of Service</a>
<a class="text-[#2e2f2d]/50 hover:text-[#386631] transition-opacity text-sm font-['Be_Vietnam_Pro']" href="#">Contact</a>
</div>
<div class="flex gap-4">
<a class="w-10 h-10 rounded-full bg-surface-variant flex items-center justify-center text-primary hover:bg-primary hover:text-white transition-all" href="#">
<span class="material-symbols-outlined text-xl">language</span>
</a>
<a class="w-10 h-10 rounded-full bg-surface-variant flex items-center justify-center text-primary hover:bg-primary hover:text-white transition-all" href="#">
<span class="material-symbols-outlined text-xl">mail</span>
</a>
</div>
</div>
</footer>

</body></html>