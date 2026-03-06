<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "bookvilla";
$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Database connection failed"]));
}
if (!isset($_GET['id'])) {
    echo json_encode(["status" => "error", "message" => "Author ID not provided"]);
    exit();
}
$author_id = $_GET['id'];
$sql = "SELECT name, image, description FROM authors WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $author_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    echo json_encode($result->fetch_assoc());
} else {
    echo json_encode(["status" => "error", "message" => "Author not found"]);
}
$stmt->close();
$conn->close();
?>
