<?php
include 'database.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    $id = $_GET['id'];

    // Check if ID is valid
    if (!$id) {
        echo json_encode(['error' => 'Invalid product ID']);
        exit;
    }

    // Prepare the SQL statement to prevent SQL injection
    $stmt = $con->prepare('SELECT * FROM products WHERE id = ?');
    if (!$stmt) {
        throw new Exception("Prepare statement failed: " . $con->error);
    }
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    if ($product) {
        // Fetch additional images if any
        $stmt = $con->prepare('SELECT image_url FROM products WHERE id = ?');
        if (!$stmt) {
            throw new Exception("Prepare statement failed: " . $con->error);
        }
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $additional_images = $result->fetch_all(MYSQLI_ASSOC);

        $product['additional_images'] = array_column($additional_images, 'image_url');
        echo json_encode($product);
    } else {
        echo json_encode(['error' => 'Product not found']);
    }

    $stmt->close();
    $con->close();
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
