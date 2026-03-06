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
    $title = $_POST['title'];
    $author = $_POST['author'];
    $discount_price = $_POST['discount_price'];
    $original_price = $_POST['original_price'];
    $discount_percentage = $_POST['discount_percentage'];
    $stock = $_POST['stock'];
    $rating = $_POST['rating'];
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
    $stmt = $conn->prepare("INSERT INTO bestsellers (title, author, image_url, discount_price, original_price, discount_percentage, rating, stock, description) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssddidis", $title, $author, $image_url, $discount_price, $original_price, $discount_percentage, $rating, $stock, $description);



    if ($stmt->execute()) {
        echo "<script>alert('Book added successfully!'); window.location='bestseller.php';</script>";
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
    <title>Add New Book</title>
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

        textarea {
            height: 80px;
            resize: none;
        }

        .rating {
            display: flex;
            flex-direction: row-reverse;
            justify-content: center;
            font-size: 24px;
            margin: 10px 0;
        }

        .rating input {
            display: none;
        }

        .rating label {
            color: #ccc;
            cursor: pointer;
            font-size: 30px;
        }

        .rating input:checked~label,
        .rating label:hover,
        .rating label:hover~label {
            color: #f7b731;
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
        <h2><i class="fas fa-book"></i> Add New Book</h2>
        <form method="post" enctype="multipart/form-data">
            <label for="title"><i class="fas fa-book-open"></i> Title</label>
            <input type="text" name="title" id="title" required>

            <label for="author"><i class="fas fa-user"></i> Author</label>
            <input type="text" name="author" id="author" required>

            <label for="original_price"><i class="fas fa-dollar-sign"></i> Original Price (₹)</label>
            <input type="number" step="0.01" name="original_price" id="original_price" required>

            <label for="discount_price"><i class="fas fa-dollar-sign"></i> Discount Price (₹)</label>
            <input type="number" step="0.01" name="discount_price" id="discount_price" required>

            <label for="discount_percentage"><i class="fas fa-percentage"></i> Discount Percentage (%)</label>
            <input type="number" name="discount_percentage" id="discount_percentage" required>

            <label for="stock"><i class="fas fa-boxes"></i> Stock</label>
            <input type="number" name="stock" id="stock" required>

            <label><i class="fas fa-star"></i> Rating</label>
            <div class="rating">
                <input type="radio" name="rating" value="5" id="star5"><label for="star5">★</label>
                <input type="radio" name="rating" value="4" id="star4"><label for="star4">★</label>
                <input type="radio" name="rating" value="3" id="star3"><label for="star3">★</label>
                <input type="radio" name="rating" value="2" id="star2"><label for="star2">★</label>
                <input type="radio" name="rating" value="1" id="star1"><label for="star1">★</label>
            </div>

            <label for="description"><i class="fas fa-align-left"></i> Description</label>
            <textarea name="description" id="description" required></textarea>

            <label for="image"><i class="fas fa-image"></i> Upload Image</label>
            <input type="file" name="image" id="image" accept="image/*" required>

            <button type="submit"><i class="fas fa-save"></i> Add Book</button>
        </form>

        <a href="bestseller.php" class="back-link"><i class="fas fa-arrow-left"></i> Back to Book List</a>
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