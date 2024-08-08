<?php
// Start the session
session_start();

// Debugging: Output the session variables before destroying
error_log('Before logout - User ID: ' . ($_SESSION['user_id'] ?? 'Not set'));

// Unset all of the session variables
$_SESSION = array();

// Destroy the session
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, 
        $params["path"], $params["domain"], 
        $params["secure"], $params["httponly"]
    );
}

// Destroy the session data in the database
session_destroy();

// Debugging: Output the session variables after destroying
error_log('After logout - User ID: ' . ($_SESSION['user_id'] ?? 'Not set'));

// Redirect to the homepage with a logout message
header("Location: index.php?message=Successfully logged out");
exit();
?>
