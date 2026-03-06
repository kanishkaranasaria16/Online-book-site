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
    $title = $_POST['name'];
    $stmt = $conn->prepare("INSERT INTO categories (name) 
                            VALUES (?)");
    $stmt->bind_param("s", $title);

    if ($stmt->execute()) {
        echo "<script>alert('Category added successfully!'); window.location='categories.php';</script>";
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
    <title>Add New Category</title>
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
            overflow-y: auto;
        }

        .container {
            background: white;
            padding: 25px;
            width: 100%;
            max-width: 800px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            overflow-y: auto;
        }

        h2 {
            text-align: center;
            color: #333;
            font-size: 30px;
            text-decoration: underline;
        }

        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
            font-size: 18px;
        }

        input,
        select,
        textarea {
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
    </style>
</head>

<body>

    <div class="container">
        <h2><i class="fas fa-book"></i> Add New Book</h2>
        <form method="post" enctype="multipart/form-data">
            <label for="name"><i class="fas fa-book-open"></i> Title</label>
            <input type="text" name="name" id="name" required>
            <button type="submit"><i class="fas fa-save"></i> Add Category</button>
        </form>

        <a href="categories.php" class="back-link"><i class="fas fa-arrow-left"></i> Back to Category List</a>
    </div>

    <script>
        function previewImage(event) {
            const preview = document.getElementById('imagePreview');
            preview.innerHTML = '';
            const img = document.createElement('img');
            img.src = URL.createObjectURL(event.target.files[0]);
            preview.appendChild(img);
        }
    </script>

</body>

</html>