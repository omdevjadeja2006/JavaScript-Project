<?php
// ============================================================
//  google_oauth_config.php
//  ── PASTE YOUR CREDENTIALS FROM GOOGLE CLOUD CONSOLE HERE ──
// ============================================================
//
//  HOW TO GET YOUR CREDENTIALS (5 minutes):
//  1. Go to https://console.cloud.google.com/
//  2. Create a new project (or select existing)
//  3. APIs & Services → OAuth consent screen
//       - User type: External → Create
//       - App name: TaskFlow, your email, save & continue
//  4. APIs & Services → Credentials → Create Credentials → OAuth client ID
//       - Application type: Web application
//       - Name: TaskFlow Local
//       - Authorised redirect URIs → Add URI:
//           http://localhost/javascriptproject/google_callback.php
//         (adjust the path to match where your project lives in htdocs)
//  5. Click Create → copy Client ID and Client Secret below
//
// ============================================================

// This MUST exactly match what you entered in Google Console above.
// Common values for XAMPP:
//   http://localhost/javascriptproject/google_callback.php
//   http://localhost/taskflow/google_callback.php


define('GOOGLE_CLIENT_ID',     '1041637574667-dttv3mr6v09k9t92i7l1sg3h78n3bgq3.apps.googleusercontent.com');
define('GOOGLE_CLIENT_SECRET', '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');
define('GOOGLE_REDIRECT_URI',  'http://localhost/javascriptproject/google_callback.php');
