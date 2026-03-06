<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = "localhost";
$user = "root"; 
$password = ""; 
$database = "bookvilla_db";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}
$search = isset($_GET['query']) ? trim($_GET['query']) : "";

if ($search !== "") {
    $searchLike = "%$search%"; 
    $sql = "SELECT id, title, author, price, stock, image_url FROM books 
            WHERE title LIKE ? OR author LIKE ?";

    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ss", $searchLike, $searchLike);
        
        $stmt->execute();
        $result = $stmt->get_result();

        $books = [];
        while ($row = $result->fetch_assoc()) {
            $books[] = $row;
        }
        if (empty($books)) {
            echo json_encode(["error" => "No books found"]);
        } else {
            echo json_encode($books);
        }

        $stmt->close();
    } else {
        die(json_encode(["error" => "SQL Prepare Failed: " . $conn->error]));
    }
} else {
    echo json_encode(["error" => "No search query provided"]);
}

$conn->close();
?>
