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

$result = $conn->query("SELECT * FROM authors WHERE id=$id");
$row = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['name'];
    $description = $_POST['description'];
    $about = $_POST['about'];
    $stmt = $conn->prepare("UPDATE authors SET name=?,description=?,about=? WHERE id=?");
    $stmt->bind_param("sdi", $title, $description, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Book updated successfully'); window.location='author.php';</script>";
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
    <title>Edit Author</title>
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
        textarea {
            height: 100px;
            resize: none;
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
    <h2>Edit Author</h2>
    <form method="post">
        <label for="title">Title</label>
        <input type="text" name="name" id="name" value="<?= htmlspecialchars($row['name']); ?>" required>

        <label for="description">About</label>
        <textarea name="about" id="about" required><?= htmlspecialchars($row['about']); ?></textarea>

        <label for="description">Description</label>
        <textarea name="description" id="description" required><?= htmlspecialchars($row['description']); ?></textarea>

        <button type="submit">Update</button>
    </form>
    <a href="author.php" class="back-link">← Back to Author List</a>
</div>

</body>
</html>
