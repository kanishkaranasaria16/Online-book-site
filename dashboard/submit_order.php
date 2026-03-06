<?php
header("Content-Type: application/json");

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bookvilla_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]));
}

$data = json_decode(file_get_contents("php://input"), true);
if (!$data || !isset($data["cart"])) {
    echo json_encode(["success" => false, "message" => "Invalid data"]);
    exit();
}

$order_id = uniqid("ORDER_");
$insert_order = "INSERT INTO orders (id, status) VALUES ('$order_id', 'Pending')";
$conn->query($insert_order);

foreach ($data["cart"] as $item) {
    $product_id = $item["id"];
    $quantity = $item["quantity"];
    $price = $item["price"];

    $insert_item = "INSERT INTO order_products (order_id, product_id, quantity, price) 
                    VALUES ('$order_id', '$product_id', '$quantity', '$price')";
    $conn->query($insert_item);
}

$conn->close();
echo json_encode(["success" => true]);
?>
