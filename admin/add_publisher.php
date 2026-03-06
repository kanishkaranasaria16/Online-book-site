<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "bookvilla";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];

    $sql = "INSERT INTO publishers (name, address, contact, email) VALUES ('$name', '$address', '$contact', '$email')";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: publisher.php");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Publisher</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 20px; }
        .container { width: 50%; margin: auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0px 0px 10px #ccc; }
        h2 { text-align: center; }
        input, textarea, button { width: 100%; margin: 5px 0; padding: 10px; }
        button { background: green; color: white; border: none; cursor: pointer; }
    </style>
</head>
<body>

<div class="container">
    <h2>Add Publisher</h2>
    <form method="POST">
        <label>Name:</label>
        <input type="text" name="name" required>
        <label>Address:</label>
        <textarea name="address" required></textarea>
        <label>Contact:</label>
        <input type="text" name="contact" required>
        <label>Email:</label>
        <input type="email" name="email" required>
        <button type="submit">Add Publisher</button>
    </form>
</div>

</body>
</html>
