<?php
// ============================================================
//  google_callback.php  — Step 2: Google redirects back here
//  Handles token exchange, user lookup/creation, and login
// ============================================================

session_start();
require_once 'google_oauth_config.php';
require_once 'db_connect.php';

// ── 1. CSRF check: verify state matches what we set ──
if (empty($_GET['state']) || $_GET['state'] !== ($_SESSION['oauth_state'] ?? '')) {
    unset($_SESSION['oauth_state']);
    header('Location: signin.html?error=oauth_csrf');
    exit();
}
unset($_SESSION['oauth_state']);

// ── 2. Check for errors from Google (e.g. user denied access) ──
if (isset($_GET['error'])) {
    header('Location: signin.html?error=google_denied');
    exit();
}

// ── 3. Exchange the authorisation code for an access token ──
if (empty($_GET['code'])) {
    header('Location: signin.html?error=google_nocode');
    exit();
}

$token_response = file_get_contents('https://oauth2.googleapis.com/token', false, stream_context_create([
    'http' => [
        'method'  => 'POST',
        'header'  => "Content-Type: application/x-www-form-urlencoded\r\n",
        'content' => http_build_query([
            'code'          => $_GET['code'],
            'client_id'     => GOOGLE_CLIENT_ID,
            'client_secret' => GOOGLE_CLIENT_SECRET,
            'redirect_uri'  => GOOGLE_REDIRECT_URI,
            'grant_type'    => 'authorization_code',
        ]),
    ],
]));

if ($token_response === false) {
    header('Location: signin.html?error=google_token_fail');
    exit();
}

$token_data   = json_decode($token_response, true);
$access_token = $token_data['access_token'] ?? null;

if (!$access_token) {
    header('Location: signin.html?error=google_token_fail');
    exit();
}

// ── 4. Fetch the user's Google profile ──
$profile_response = file_get_contents('https://www.googleapis.com/oauth2/v2/userinfo', false, stream_context_create([
    'http' => [
        'header' => "Authorization: Bearer $access_token\r\n",
    ],
]));

if ($profile_response === false) {
    header('Location: signin.html?error=google_profile_fail');
    exit();
}

$profile = json_decode($profile_response, true);
$google_id    = $profile['id']             ?? null;
$google_email = $profile['email']          ?? null;
$google_name  = $profile['name']           ?? null;
$google_pic   = $profile['picture']        ?? null;
$email_verified = $profile['verified_email'] ?? false;

if (!$google_id || !$google_email) {
    header('Location: signin.html?error=google_profile_fail');
    exit();
}

// ── 5. Look up existing user by google_id OR email ──
//
//  DB MIGRATION — run this ONCE in phpMyAdmin before using Google login:
//
//    ALTER TABLE users
//      ADD COLUMN google_id VARCHAR(64)  DEFAULT NULL,
//      ADD COLUMN avatar    VARCHAR(512) DEFAULT NULL;
//
//    CREATE UNIQUE INDEX idx_google_id ON users (google_id);
//
$google_id_safe = mysqli_real_escape_string($conn, $google_id);
$email_safe     = mysqli_real_escape_string($conn, $google_email);

$existing = mysqli_query($conn,
    "SELECT id, username FROM users
     WHERE google_id = '$google_id_safe' OR email = '$email_safe'
     LIMIT 1"
);
$user = mysqli_fetch_assoc($existing);

if ($user) {
    // ── 5a. User exists → update google_id / avatar if not set, then log in ──
    mysqli_query($conn,
        "UPDATE users
         SET google_id = '$google_id_safe',
             avatar    = '" . mysqli_real_escape_string($conn, $google_pic ?? '') . "'
         WHERE id = '{$user['id']}'"
    );

    $_SESSION['user_id']  = $user['id'];
    $_SESSION['username'] = $user['username'];
    header('Location: dashboard.php');
    exit();

} else {
    // ── 5b. New user → auto-create account from Google profile ──
    //
    //  Username: derived from the Google display name, made URL-safe + unique.
    //  Password: NULL (they'll always sign in via Google; they can set one later).
    //

    // Build a clean base username from the Google name
    $base_username = strtolower(preg_replace('/[^a-zA-Z0-9_]/', '', str_replace(' ', '_', $google_name ?? 'user')));
    if (strlen($base_username) < 3) $base_username = 'user';

    // Ensure uniqueness by appending a number if needed
    $username_candidate = $base_username;
    $suffix = 1;
    while (true) {
        $uc_safe = mysqli_real_escape_string($conn, $username_candidate);
        $check   = mysqli_query($conn, "SELECT id FROM users WHERE username = '$uc_safe' LIMIT 1");
        if (mysqli_num_rows($check) === 0) break;
        $username_candidate = $base_username . $suffix;
        $suffix++;
    }

    $pic_safe      = mysqli_real_escape_string($conn, $google_pic ?? '');
    $name_safe     = mysqli_real_escape_string($conn, $username_candidate);

    $insert = mysqli_query($conn,
        "INSERT INTO users (username, email, password, google_id, avatar)
         VALUES ('$name_safe', '$email_safe', NULL, '$google_id_safe', '$pic_safe')"
    );

    if (!$insert) {
        header('Location: signin.html?error=google_db_fail');
        exit();
    }

    $new_id = mysqli_insert_id($conn);
    $_SESSION['user_id']  = $new_id;
    $_SESSION['username'] = $username_candidate;

    // Send to dashboard with a welcome flag so we can greet them
    header('Location: dashboard.php?google_welcome=1');
    exit();
}
