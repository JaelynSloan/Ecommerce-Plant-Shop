<?php
// Include your database connection file
include 'database.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Prepare and execute the SQL statement
    $sql = "INSERT INTO contact_form (name, email, message) VALUES (?, ?, ?)";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("sss", $name, $email, $message);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Thank you! Your message has been sent."]);
    } else {
        echo json_encode(["success" => false, "message" => "Sorry, something went wrong. Please try again later."]);
    }

    $stmt->close();
}

// Close the database connection
$con->close();
?>
