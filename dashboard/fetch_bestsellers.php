<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "bookvilla";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM bestsellers ORDER BY id DESC";
$result = $conn->query($sql);

$bestsellers = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $bestsellers[] = $row;
    }
}

echo json_encode($bestsellers);

$conn->close();
?>
