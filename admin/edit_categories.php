<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "bookvilla";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_GET['id'] ?? 0;
$id = (int) $id;

$result = $conn->query("SELECT * FROM categories WHERE id=$id");
$row = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['name'];
    $stmt = $conn->prepare("UPDATE bestsellers SET name=? WHERE id=?");
    $stmt->bind_param("sdisssdi", $title, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Category updated successfully'); window.location='categories.php';</script>";
    } else {
        echo "Error updating record: " . $conn->error;
    }
    $stmt->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Book</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: white;
            padding: 30px;
            width: 100%;
            max-width: 800px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow-y: auto;
            margin-top: 10%;
        }
        h2 {
            text-align: center;
            color: #333;
            font-size: 26px;
            text-decoration: underline;
        }
        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
            font-size: 18px;
        }
        input, textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        button {
            width: 100%;
            padding: 12px;
            background:green;
            color: white;
            border: none;
            cursor: pointer;
            margin-top: 15px;
            font-size: 18px;
            border-radius: 5px;
        }
        button:hover {
            background:rgb(18, 140, 20);
        }
        .back-link {
            text-align: center;
            display: block;
            margin-top: 15px;
            text-decoration: none;
            color: black;
            font-size: 16px;
        }
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Edit Category</h2>
    <form method="post">
        <label for="name">Title</label>
        <input type="text" name="name" id="name" value="<?= htmlspecialchars($row['name']); ?>" required>
        <button type="submit">Update</button>
    </form>
    <a href="categories.php" class="back-link">← Back to Category List</a>
</div>

</body>
</html>
