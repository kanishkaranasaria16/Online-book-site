<?php
include "db.php"; // Database connection

$query = "SELECT * FROM books";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Store</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 20px;
            background-color: #f8f8f8;
        }
        h2 {
            text-align: center;
        }
        .book-list {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
        .book-card {
            width: 200px;
            border: 1px solid #ddd;
            background-color: white;
            padding: 10px;
            margin: 10px;
            text-align: center;
            cursor: pointer;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease-in-out;
        }
        .book-card:hover {
            transform: scale(1.05);
        }
        .book-card img {
            width: 100px;
            height: 150px;
            object-fit: cover;
        }
    </style>
</head>
<body>

<h2>Book List</h2>
<div class="book-list">
    <?php while ($row = $result->fetch_assoc()): ?>
        <div class="book-card" onclick="window.location.href='book_detail.php?id=<?= $row['id'] ?>'">
            <img src="<?= $row['image'] ?>" alt="<?= htmlspecialchars($row['title']) ?>">
            <h3><?= htmlspecialchars($row['title']) ?></h3>
            <p>by <?= htmlspecialchars($row['author']) ?></p>
            <p>₹<?= htmlspecialchars($row['price']) ?></p>
        </div>
    <?php endwhile; ?>
</div>

</body>
</html>
