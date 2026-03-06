<?php
// Database Connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "bookvilla_db";

$conn = new mysqli($servername, $username, $password, $database);

// Check Connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get JSON data
$data = json_decode(file_get_contents("php://input"), true);
$cart_id = $data['cart_id'];

// Delete item from cart
$sql = "DELETE FROM cart WHERE id = $cart_id";

if ($conn->query($sql) === TRUE) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => $conn->error]);
}

$conn->close();
?>
