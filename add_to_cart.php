<?php
ob_start();
include 'database.php'; 
include 'session_handler.php';

$handler = new MySessionHandler($con);
session_set_save_handler($handler, true);

session_start();

// Enable error logging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    if (isset($data['product_id'])) {
        $productId = $data['product_id'];
        $quantity = 1; // Default quantity, adjust as needed

        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];

            // Step 1: Check if the user has an active cart
            $stmt = $con->prepare("
                SELECT carts.cart_id 
                FROM carts 
                JOIN cart_items ON carts.cart_id = cart_items.cart_id 
                WHERE carts.user_id = ? 
                LIMIT 1
            ");
            $stmt->bind_param('i', $userId);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows == 0) {
                // No active cart found, create a new cart
                $stmt->close();
                $stmt = $con->prepare("INSERT INTO carts (user_id, created_at) VALUES (?, NOW())");
                $stmt->bind_param('i', $userId);
                $stmt->execute();
                $cartId = $stmt->insert_id;
            } else {
                // Active cart found, retrieve the cart ID
                $stmt->bind_result($cartId);
                $stmt->fetch();
            }
            $stmt->close();
        } else {
            // User is not logged in, use session ID to track cart
            $sessionId = session_id();

            // Step 1: Check if the session has an active cart
            $stmt = $con->prepare("
                SELECT carts.cart_id 
                FROM carts 
                JOIN cart_items ON carts.cart_id = cart_items.cart_id 
                WHERE carts.session_id = ? 
                LIMIT 1
            ");
            $stmt->bind_param('s', $sessionId);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows == 0) {
                // No active cart found, create a new cart
                $stmt->close();
                $stmt = $con->prepare("INSERT INTO carts (session_id, created_at) VALUES (?, NOW())");
                $stmt->bind_param('s', $sessionId);
                $stmt->execute();
                $cartId = $stmt->insert_id;
            } else {
                // Active cart found, retrieve the cart ID
                $stmt->bind_result($cartId);
                $stmt->fetch();
            }
            $stmt->close();
        }

        // Step 2: Add the product to the cart_items table
        $stmt = $con->prepare("INSERT INTO cart_items (cart_id, product_id, quantity) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE quantity = quantity + VALUES(quantity)");
        $stmt->bind_param('iii', $cartId, $productId, $quantity);

        if ($stmt->execute()) {
            // Step 3: Get the updated cart count
            $stmt = $con->prepare("SELECT SUM(quantity) FROM cart_items WHERE cart_id = ?");
            $stmt->bind_param('i', $cartId);
            $stmt->execute();
            $stmt->bind_result($cartCount);
            $stmt->fetch();
            echo json_encode(['status' => 'success', 'cartCount' => $cartCount]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to add item to cart.']);
        }

        $stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
    }

    // Explicitly close session before closing DB connection
    session_write_close();
    $con->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
}

ob_end_flush();
?>
