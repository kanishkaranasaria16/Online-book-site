<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "bookvilla";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$id = $_GET['id'];
$conn->query("DELETE FROM publishers WHERE publisher_id=$id");

header("Location: publisher.php");
?>
