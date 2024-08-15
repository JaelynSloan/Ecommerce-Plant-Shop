<?php
include 'database.php';
include 'session_handler.php';

$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$sql = "SELECT * FROM products WHERE product_id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

$product = $result->fetch_assoc();

if (!$product) {
    echo json_encode(['error' => 'Product not found!']);
    exit();
}

// Collect all image URLs
$product['additional_images'] = [
    $product['image2_url'],
    $product['image3_url'],
    $product['image4_url'],
    $product['image5_url']
];

// Remove null or empty URLs
$product['additional_images'] = array_filter($product['additional_images']);

// Return product details as JSON
header('Content-Type: application/json');
echo json_encode($product);
?>
