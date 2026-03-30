<?php
// ============================================================
//  google_auth.php  — Step 1: Send the user to Google
//  Linked to from signin.html and Login.html Google button
// ============================================================

session_start();
require_once 'google_oauth_config.php';

// Generate a random state token to prevent CSRF
$state = bin2hex(random_bytes(16));
$_SESSION['oauth_state'] = $state;

// Build Google's authorisation URL
$params = http_build_query([
    'client_id'     => GOOGLE_CLIENT_ID,
    'redirect_uri'  => GOOGLE_REDIRECT_URI,
    'response_type' => 'code',
    'scope'         => 'openid email profile',
    'access_type'   => 'online',
    'state'         => $state,
    'prompt'        => 'select_account',   // always show account picker
]);

header('Location: https://accounts.google.com/o/oauth2/v2/auth?' . $params);
exit();
