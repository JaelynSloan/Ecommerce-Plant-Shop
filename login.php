<?php
ob_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'database.php'; 
include 'session_handler.php';

$handler = new MySessionHandler($con);
session_set_save_handler($handler, true);
session_start();

if (!$con) {
    header("Location: login.html?error=Database connection failed.");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $con->prepare("SELECT * FROM users WHERE username = ?");
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($con->error));
    }
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password_hash'])) {
            $_SESSION['user_id'] = $user['user_id'];
            header("Location: index.php");
            exit();
        } else {
            header("Location: login.html?error=Invalid password.");
            exit();
        }
    } else {
        header("Location: login.html?error=No user found with that username.");
        exit();
    }
} else {
    header("Location: login.html");
    exit();
}

ob_end_flush();
?>
