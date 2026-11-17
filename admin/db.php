<?php
require_once __DIR__ . '/../includes/db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Check if admin is logged in, if not redirect to login page
 */
function checkLogin() {
    if(!isset($_SESSION['admin_logged_in'])) {
        header("Location: login.php");
        exit();
    }
}
?>
