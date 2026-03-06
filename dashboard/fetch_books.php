<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "bookvilla";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

$category_id = isset($_GET['category_id']) ? intval($_GET['category_id']) : 0;

$sql = "SELECT books.id, books.title, books.author, books.price, books.original_price, 
               books.stock, books.image_url, books.discount_percentage, books.rating,
               categories.name AS category
        FROM books 
        JOIN categories ON books.category_id = categories.id";

if ($category_id > 0) {
    $sql .= " WHERE books.category_id = $category_id";
}

$result = $conn->query($sql);

$books = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $books[] = $row;
    }
} else {
    die(json_encode(["error" => "Query error: " . $conn->error]));
}

header('Content-Type: application/json');
echo json_encode($books);
$conn->close();
?>
