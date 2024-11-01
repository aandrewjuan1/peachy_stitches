<?php
require_once 'core/auth.php'; // Ensure auth functions are available

requireAuth(); // Only allow access to logout.php if the user is logged in

// Destroy the session to log out the user
session_start();
session_unset();
session_destroy();

// Redirect to login page
header("Location: login.php");
exit;
?>
