<?php
$conn = new mysqli("localhost", "root", "", "bookvilla");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM authors  ";
$result = $conn->query($sql);

$authors = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $authors[] = $row;
    }
}

echo json_encode($authors);
$conn->close();
?>
