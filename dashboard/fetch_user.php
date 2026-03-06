<?php
session_start();
$conn = new mysqli("localhost", "root", "", "bookvilla");
if ($conn->connect_error) {
    die(json_encode(["error" => "Database connection failed: " . $conn->connect_error]));
}
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["error" => "User not logged in"]);
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT name, email, phonenumber AS phone, address FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die(json_encode(["error" => "SQL error: " . $conn->error]));
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode($result->fetch_assoc());
} else {
    echo json_encode(["error" => "User not found"]);
}

$stmt->close();
$conn->close();
?>
