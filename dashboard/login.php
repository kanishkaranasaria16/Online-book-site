<?php
session_start();
header("Content-Type: application/json");
if (empty($_POST)) {
    die(json_encode(["status" => "error", "message" => "No POST data received"]));
}

$conn = new mysqli("localhost", "root", "", "bookvilla");

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Database connection failed"]));
}
$identifier = isset($_POST['identifier']) ? trim($_POST['identifier']) : null;
$password = isset($_POST['password']) ? trim($_POST['password']) : null;

if (!$identifier || !$password) {
    die(json_encode(["status" => "error", "message" => "Missing identifier or password"]));
}
$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $identifier);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    echo json_encode(["status" => "success", "user_id" => $user['id']]);
} else {
    echo json_encode(["status" => "error", "message" => "Invalid credentials"]);
}

$stmt->close();
$conn->close();
?>
