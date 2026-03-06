<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bookvilla";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$book_id = $_GET['book_id'];
$sql = "SELECT * FROM books WHERE id = $book_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $book = $result->fetch_assoc();
    echo json_encode($book);
} else {
    echo json_encode(null);
}

$conn->close();
?>
