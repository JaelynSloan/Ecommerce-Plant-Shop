<?php
include 'database.php'; 
include 'session_handler.php';

$handler = new MySessionHandler($con);
session_set_save_handler($handler, true);
session_start();

$product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0;

if ($product_id > 0) {
    if (isset($_SESSION['user_id'])) {
        // User is signed in
        $user_id = $_SESSION['user_id'];
        $stmt = $con->prepare("DELETE ci FROM cart_items ci JOIN carts c ON ci.cart_id = c.cart_id WHERE c.user_id = ? AND ci.product_id = ?");
        $stmt->bind_param("ii", $user_id, $product_id);
        $stmt->execute();
        $stmt->close();
    } else {
        // User is not signed in, use session ID to track cart
        $sessionId = session_id();

        // Get the cart_id for the current session
        $stmt = $con->prepare("SELECT cart_id FROM carts WHERE session_id = ?");
        $stmt->bind_param('s', $sessionId);
        $stmt->execute();
        $stmt->bind_result($cart_id);
        if ($stmt->fetch()) {
            // Delete the item from cart_items
            $stmt->close();
            $stmt = $con->prepare("DELETE FROM cart_items WHERE cart_id = ? AND product_id = ?");
            $stmt->bind_param('ii', $cart_id, $product_id);
            $stmt->execute();
        }
        $stmt->close();
    }
}

header("Location: cart.php");
exit();
?>
