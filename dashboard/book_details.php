<?php
include "db.php";

if (isset($_GET['id'])) {
    $book_id = $_GET['id'];
    $query = "SELECT * FROM books WHERE id = $book_id";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $book = $result->fetch_assoc();
    } else {
        echo "Book not found.";
        exit;
    }
} else {
    echo "Invalid request.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $book['title'] ?></title>
</head>
<body>

<h2><?= $book['title'] ?></h2>
<img src="<?= $book['image'] ?>" width="150" alt="<?= $book['title'] ?>">
<p><strong>Author:</strong> <?= $book['author'] ?></p>
<p><strong>Price:</strong> ₹<?= $book['price'] ?></p>
<p><strong>Description:</strong> <?= $book['description'] ?></p>
<a href="index.php">Back to Book List</a>

</body>
</html>
