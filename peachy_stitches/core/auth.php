<?php
session_start();

/**
 * Redirect to login if user is not authenticated.
 */
function requireAuth() {
    if (!isset($_SESSION['user'])) {
        header("Location: login.php");
        exit;
    }
}

/**
 * Redirect to projects if user is already authenticated.
 */
function redirectIfAuthenticated() {
    if (isset($_SESSION['user'])) {
        header("Location: index.php");
        exit;
    }
}
?>
