<?php
$conn = new mysqli("localhost", "root", "", "your_database");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result = $conn->query("SELECT id, name FROM authors");

echo "<ul>";
while ($row = $result->fetch_assoc()) {
    echo "<li><a href='author.html?id=" . $row["id"] . "'>" . $row["name"] . "</a></li>";
}
echo "</ul>";

$conn->close();
?>
