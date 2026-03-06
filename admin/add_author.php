<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "bookvilla";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $about = $_POST['about'];
    $description = $_POST['description'];
    $targetDir = "images/";
    $imageFileName = basename($_FILES["image"]["name"]);
    $targetFilePath = $targetDir . $imageFileName;

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
        $image_url = $targetFilePath;
    } else {
        echo "Error uploading image.";
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO authors (name, image, description, about) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $image_url, $description, $about);

    if ($stmt->execute()) {
        echo "<script>alert('Author added successfully!'); window.location='author.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Author</title>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
            box-sizing: border-box;
        }

        .container {
            background: white;
            padding: 25px;
            width: 100%;
            max-width: 600px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
        }

        h2 {
            text-align: center;
            color: #333;
            font-size: 28px;
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
            height: 80px;
            resize: none;
        }

        button {
            width: 100%;
            padding: 12px;
            background: green;
            color: white;
            border: none;
            cursor: pointer;
            margin-top: 15px;
            font-size: 18px;
            border-radius: 5px;
        }

        button:hover {
            background: rgb(18, 140, 20);
        }

        .back-link {
            text-align: center;
            display: block;
            margin-top: 10px;
            text-decoration: none;
            color: black;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        .image-preview {
            width: 100%;
            height: 150px;
            border: 1px solid #ddd;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 10px;
            overflow: hidden;
        }

        .image-preview img {
            max-width: 100%;
            max-height: 150px;
            object-fit: cover;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2><i class="fas fa-user"></i> Add New Author</h2>
        <form method="post" enctype="multipart/form-data">
            <label for="name"><i class="fas fa-user"></i> Author Name</label>
            <input type="text" name="name" id="name" required>

            <label for="about"><i class="fas fa-info-circle"></i> About</label>
            <textarea name="about" id="about" required></textarea>

            <label for="description"><i class="fas fa-align-left"></i> Description</label>
            <textarea name="description" id="description" required></textarea>

            <label for="image"><i class="fas fa-image"></i> Upload Image</label>
            <input type="file" name="image" id="image" accept="image/*" required>

            <button type="submit"><i class="fas fa-save"></i> Add Author</button>
        </form>

        <a href="author.php" class="back-link"><i class="fas fa-arrow-left"></i> Back to Author List</a>
    </div>

</body>

</html>
