<?php
session_start();

// Include database connection file
include 'db_connection.php';

// Check if user is logged in, if not, redirect to login page
if (!isset($_SESSION['username'])) {
    header('Location: admin_login.php');
    exit();
}

// Check if user ID is provided in the URL parameter
if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Retrieve user details based on the provided user ID
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows > 0) {
        // Fetch user details
        $user = $result->fetch_assoc();

        // Perform user deletion operation
        $deleteStmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        $deleteStmt->bind_param("i", $userId);
        $deleteStmt->execute();

        // Check if deletion was successful
        if ($deleteStmt->affected_rows > 0) {
            // Deletion successful, redirect back to manage users page
            header('Location: manage_users.php');
            exit();
        } else {
            // Deletion failed, redirect with error message
            header('Location: manage_users.php?error=delete_failed');
            exit();
        }
    } else {
        // User with provided ID does not exist, redirect with error message
        header('Location: manage_users.php?error=user_not_found');
        exit();
    }
} else {
    // Redirect to manage users page if user ID is not provided
    header('Location: manage_users.php');
    exit();
}

// Close prepared statements and database connection
$stmt->close();
$deleteStmt->close();
$conn->close();
?>
