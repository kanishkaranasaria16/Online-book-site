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
    $conn->query("DELETE FROM order_items WHERE order_id = $orderId");
    if ($conn->query("DELETE FROM orders WHERE id = $orderId")) {
        echo "Success";
    } else {
        echo "Error";
    }
}

$conn->close();
?>
