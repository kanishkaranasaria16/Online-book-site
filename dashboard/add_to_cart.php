<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "bookvilla_db";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$data = json_decode(file_get_contents("php://input"), true);
$user_id = $data['user_id'];
$book_title = $data['book_title'];
$price = $data['price'];

// Check if book already exists in cart
$sql = "SELECT * FROM cart WHERE user_id = $user_id AND book_title = '$book_title'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // If book exists, update quantity
    $sql = "UPDATE cart SET quantity = quantity + 1 WHERE user_id = $user_id AND book_title = '$book_title'";
} else {
    // Otherwise, insert new book
    $sql = "INSERT INTO cart (user_id, book_title, price, quantity) VALUES ($user_id, '$book_title', $price, 1)";
}

if ($conn->query($sql) === TRUE) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => $conn->error]);
}

$conn->close();
?>
