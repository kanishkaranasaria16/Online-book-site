<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "bookvilla";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$categoryOptions = "";
$categoryQuery = "SELECT id, name FROM categories";
$result = $conn->query($categoryQuery);
while ($row = $result->fetch_assoc()) {
    $categoryOptions .= "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $price = $_POST['price'];
    $original_price = $_POST['original_price'];
    $discount_percentage = $_POST['discount_percentage'];
    $stock = $_POST['stock'];
    $author = $_POST['author'];
    $description = $_POST['description'];
    $rating = $_POST['rating'];
    $category_id = $_POST['category'];
    $targetDir = "images/";
    $imageFileName = basename($_FILES["image"]["name"]);
    $targetFilePath = $targetDir . $imageFileName;
    move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath);
    $sql = "INSERT INTO books (title, price,original_price, discount_percentage,stock, author, description, rating, category_id, image_url) 
            VALUES ('$title', '$price','$original_price','$discount_percentage' '$stock', '$author', '$description', '$rating', '$category_id', '$targetFilePath')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Book added successfully!'); window.location='product.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
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
            margin-top: 10px;
            text-decoration: none;
            color:black;
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

            <label for="price"><i class="fas fa-dollar-sign"></i> Price (₹)</label>
            <input type="number" step="0.01" name="price" id="price" required>

            <label for="price"><i class="fas fa-dollar-sign"></i> Original Price (₹)</label>
            <input type="number" step="0.01" name="original_price" id="original_price" required>
            
            <label for="price"><i class="fas fa-dollar-sign"></i> Discount Price (₹)</label>
            <input type="number" step="0.01" name="discount_percentage" id="discount_percentage	" required>

            <label for="stock"><i class="fas fa-boxes"></i> Stock</label>
            <input type="number" name="stock" id="stock" required>

            <label for="author"><i class="fas fa-user"></i> Author</label>
            <input type="text" name="author" id="author" required>

            <label for="category"><i class="fas fa-list"></i> Category</label>
            <select name="category" id="category" required>
                <option value="">Select Category</option>
                <?= $categoryOptions ?>
            </select>

            <label for="description"><i class="fas fa-align-left"></i> Description</label>
            <textarea name="description" id="description" required></textarea>

            <label><i class="fas fa-star"></i> Rating</label>
            <div class="rating">
                <input type="radio" name="rating" value="5" id="star5"><label for="star5">★</label>
                <input type="radio" name="rating" value="4" id="star4"><label for="star4">★</label>
                <input type="radio" name="rating" value="3" id="star3"><label for="star3">★</label>
                <input type="radio" name="rating" value="2" id="star2"><label for="star2">★</label>
                <input type="radio" name="rating" value="1" id="star1"><label for="star1">★</label>
            </div>

            <label for="image"><i class="fas fa-image"></i> Upload Image</label>
            <input type="file" name="image" id="image" accept="image/*" required onchange="previewImage(event)">

            <div class="image-preview" id="imagePreview">
                <span>No image selected</span>
            </div>

            <button type="submit"><i class="fas fa-save"></i> Add Book</button>
        </form>
        <a href="product.php" class="back-link"><i class="fas fa-arrow-left"></i> Back to Book List</a>
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