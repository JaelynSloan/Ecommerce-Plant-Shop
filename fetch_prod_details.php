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
    $stmt = $con->prepare('SELECT name, description, price, image_url, image2_url, image3_url, image4_url, image5_url FROM products WHERE id = ?');
    if (!$stmt) {
        throw new Exception("Prepare statement failed: " . $con->error);
    }
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    if ($product) {
        // Collect additional images
        $additional_images = [];
        for ($i = 2; $i <= 5; $i++) {
            if (!empty($product["image{$i}_url"])) {
                $additional_images[] = $product["image{$i}_url"];
            }
        }
        $product['additional_images'] = $additional_images;
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
