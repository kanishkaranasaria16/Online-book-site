<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bookvilla";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $orderId = $_POST['id'];
    $newStatus = $_POST['status'];

    $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $newStatus, $orderId);

    if ($stmt->execute()) {
        echo "Success";
    } else {
        echo "Error";
    }

    $stmt->close();
}

$conn->close();
?>
