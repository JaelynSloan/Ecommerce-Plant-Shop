<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'database.php'; // Include your database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $passwordMatch = $_POST['passwordMatch'];

    // Validate password requirements
    $errors = [];
    
    if (strlen($password) < 8) {
        $errors[] = 'Password must be at least 8 characters long.';
    }
    if (!preg_match('/[A-Za-z]/', $password)) {
        $errors[] = 'Password must contain at least one letter.';
    }
    if (!preg_match('/[0-9]/', $password)) {
        $errors[] = 'Password must contain at least one number.';
    }
    if (!preg_match('/[\W_]/', $password)) {
        $errors[] = 'Password must contain at least one special character.';
    }
    if ($password !== $passwordMatch) {
        $errors[] = 'Passwords do not match.';
    }

    if (!empty($errors)) {
        // Redirect with error messages
        $errorMessages = implode('<br>', $errors);
        header("Location: login.php?error=$errorMessages");
        exit();
    }

    // Hash the password
    $passwordHash = password_hash($password, PASSWORD_BCRYPT);

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
        header("Location: login.php?error=Username or email already taken.");
        exit();
    } else {
        // Insert new user into the database
        $stmt = $con->prepare("INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)");
        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($con->error));
        }
        $stmt->bind_param("sss", $username, $email, $passwordHash);
        if ($stmt->execute()) {
            header("Location: login.php?success=Account created successfully.");
            exit();
        } else {
            header("Location: login.php?error=Error creating account.");
            exit();
        }
    }
} else {
    header("Location: login.php");
    exit();
}
