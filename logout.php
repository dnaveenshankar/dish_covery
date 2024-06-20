<?php
// Start session
session_start();

// If the user is logged in, destroy the session
if (isset($_SESSION['username'])) {
    // Unset all session variables
    $_SESSION = [];

    // Destroy the session
    session_destroy();

    // Redirect to the login page or any other page as needed
    header("Location: login.php");
    exit();
} else {
    // If the user is not logged in, redirect to the login page
    header("Location: login.php");
    exit();
}
?>
