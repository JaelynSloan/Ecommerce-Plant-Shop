<?php
header('Content-Type: application/json');

include 'database.php';

$sql = "SELECT * FROM products";
$result = $con->query($sql);

$products = array();

if ($result) {
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
    }
} else {
    echo json_encode(["error" => "Error fetching products: " . $con->error]);
    exit();
}

echo json_encode($products);

$con->close();
?>

