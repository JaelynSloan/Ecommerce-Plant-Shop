<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'database.php'; // Include your database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash the password

    // Check if username or email already exists
    $stmt = $con->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($con->error));
    }
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User already exists
        header("Location: login.html?error=Username or email already taken.");
        exit();
    } else {
        // Insert new user into the database
        $stmt = $con->prepare("INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)");
        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($con->error));
        }
        $stmt->bind_param("sss", $username, $email, $password);
        if ($stmt->execute()) {
            header("Location: login.html?success=Account created successfully.");
            exit();
        } else {
            header("Location: login.html?error=Error creating account.");
            exit();
        }
    }
} else {
    header("Location: login.html");
    exit();
}
?>
