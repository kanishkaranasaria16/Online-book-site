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

$result = $conn->query("SELECT * FROM bestsellers WHERE id=$id");
$row = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $price = $_POST['discount_price'];
    $stock = $_POST['stock'];
    $author = $_POST['author'];
    $description = $_POST['description'];
    $original_price = $_POST['original_price'];
    $discount_percentage = $_POST['discount_percentage'];
    $rating = $_POST['rating'] ?? 1;

    $stmt = $conn->prepare("UPDATE bestsellers SET title=?, discount_price=?, stock=?, author=?, description=?, original_price=?, discount_percentage=?, rating=? WHERE id=?");
    $stmt->bind_param("sdisssdii", $title, $price, $stock, $author, $description, $original_price, $discount_percentage, $rating, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Book updated successfully'); window.location='bestseller.php';</script>";
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
        textarea {
            height: 100px;
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
            margin-top: 15px;
            text-decoration: none;
            color: black;
            font-size: 16px;
        }
        .back-link:hover {
            text-decoration: underline;
        }
        .star-rating {
            display: flex;
            flex-direction: row-reverse;
            justify-content: center;
            margin-top: 10px;
        }
        .star-rating input {
            display: none;
        }
        .star-rating label {
            font-size: 30px;
            color: #ccc;
            cursor: pointer;
            transition: color 0.3s;
        }
        .star-rating input:checked ~ label,
        .star-rating label:hover,
        .star-rating label:hover ~ label {
            color: gold;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Edit Book</h2>
    <form method="post">
        <label for="title">Title</label>
        <input type="text" name="title" id="title" value="<?= htmlspecialchars($row['title']); ?>" required>

        <label for="price">Price (₹)</label>
        <input type="number" step="0.01" name="discount_price" id="discount_price" value="<?= isset($row['discount_price']) ? $row['discount_price'] : ''; ?>" required>

        <label for="original_price">Original Price (₹)</label>
        <input type="number" step="0.01" name="original_price" id="original_price" value="<?= $row['original_price']; ?>" required>

        <label for="discount_percentage">Discount Percentage (%)</label>
        <input type="number" step="0.01" name="discount_percentage" id="discount_percentage" value="<?= $row['discount_percentage']; ?>" required>

        <label for="stock">Stock</label>
        <input type="number" name="stock" id="stock" value="<?= isset($row['stock']) ? $row['stock'] : ''; ?>" required>

        <label for="author">Author</label>
        <input type="text" name="author" id="author" value="<?= htmlspecialchars($row['author']); ?>" required>

        <label for="description">Description</label>
        <textarea name="description" id="description" required><?= htmlspecialchars($row['description']); ?></textarea>

        <label for="rating">Rating</label>
        <div class="star-rating">
            <?php
            $currentRating = round($row['rating']);
            for ($i = 5; $i >= 1; $i--) {
                $checked = ($i == $currentRating) ? "checked" : "";
                echo "<input type='radio' name='rating' id='star$i' value='$i' $checked>
                      <label for='star$i'>&#9733;</label>";
            }
            ?>
        </div>

        <button type="submit">Update</button>
    </form>
    <a href="bestseller.php" class="back-link">← Back to Book List</a>
</div>

</body>
</html>
