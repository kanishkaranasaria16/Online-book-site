<?php
header("Content-Type: application/json");
$conn = new mysqli("localhost", "root", "", "bookvilla");

if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Database connection failed"]));
}

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['name'], $data['phone'], $data['address'], $data['payment_method'], $data['total_items'], $data['total_price'], $data['cart'])) {
    echo json_encode(["success" => false, "message" => "Invalid input data"]);
    exit;
}

$name = $conn->real_escape_string($data['name']);
$phone = $conn->real_escape_string($data['phone']);
$address = $conn->real_escape_string($data['address']);
$payment_method = $conn->real_escape_string($data['payment_method']);
$total_items = (int)$data['total_items'];
$total_price = (float)$data['total_price'];

$conn->begin_transaction();

try {
    $sql = "INSERT INTO orders (name, phone, address, payment_method, total_items, total_price, order_date) 
            VALUES ('$name', '$phone', '$address', '$payment_method', $total_items, $total_price, NOW())";
    
    if (!$conn->query($sql)) {
        throw new Exception("Error inserting order: " . $conn->error);
    }
    $order_id = $conn->insert_id;
    $stmt = $conn->prepare("INSERT INTO order_items (order_id, book_name, quantity) VALUES (?, ?, ?)");
    foreach ($data['cart'] as $item) {
        $book_name = $item['title'];
        $quantity = (int)$item['quantity'];
        $stmt->bind_param("isi", $order_id, $book_name, $quantity);
        
        if (!$stmt->execute()) {
            throw new Exception("Error inserting order item: " . $stmt->error);
        }
    }
    
    $conn->commit();
    echo json_encode(["success" => true, "message" => "Order placed successfully"]);
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}

$conn->close();
?>
