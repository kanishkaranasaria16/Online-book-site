<?php
$conn = new mysqli("localhost", "root", "", "bookvilla");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$author_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$author_query = "SELECT * FROM authors WHERE id = $author_id";
$author_result = $conn->query($author_query);

if ($author_result->num_rows > 0) {
    $author = $author_result->fetch_assoc();
} else {
    die("Author not found.");
}
$books_query = "SELECT * FROM books WHERE author_id = $author_id";
$books_result = $conn->query($books_query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $author['name']; ?> - Books</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            padding: 20px;
            background: #ffffff;
            color: #333;
            text-align: center;
        }

        .container {
            max-width: 900px;
            margin: auto;
            padding: 40px;
            background: #ffffff;
            border-radius: 8px;
        }

        .author-info {
            display: flex;
            align-items: center;
            gap: 30px;
            justify-content: center;
            margin-bottom: 30px;
        }

        .author-info img {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #ddd;
        }

        h1 {
            font-size: 32px;
            font-weight: bold;
            margin: 0;
        }

        h2 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        p {
            font-size: 18px;
            line-height: 1.6;
        }

        .book {
            display: flex;
            align-items: center;
            gap: 20px;
            padding: 20px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        .book img {
            width: 120px;
            height: 180px;
            object-fit: cover;
            border: 2px solid #ccc;
        }

        .price {
            color: green;
            font-weight: bold;
            font-size: 18px;
        }

        .original-price {
            text-decoration: line-through;
            color: red;
            margin-left: 10px;
            font-size: 16px;
        }

        .book-info {
            flex-grow: 1;
        }

        .illustration {
            margin-top: 30px;
        }

        .illustration img {
            max-width: 80%;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="author-info">
            <img src="<?php echo $author['image']; ?>" alt="Author Image">
            <div>
                <h1><?php echo $author['name']; ?></h1>
                <p><?php echo $author['description']; ?></p>
                <p><?php echo $author['about']; ?></p>
            </div>
        </div>

        <h2>Books by <?php echo $author['name']; ?></h2>

        <?php if ($books_result->num_rows > 0): ?>
            <?php while ($book = $books_result->fetch_assoc()): ?>
                <div class="book">
                    <a href="books_details.php?id=<?php echo $book['id']; ?>">
                        <img src="<?php echo $book['image_url']; ?>" alt="Book Image">
                    </a>
                    <div>
                        <h3>
                            <a href="book_details.php?id=<?php echo $book['id']; ?>">
                                <?php echo $book['title']; ?>
                            </a>
                        </h3>
                        <p>
                            <span class="price">$<?php echo $book['price']; ?></span>
                            <span class="original-price">$<?php echo $book['original_price']; ?></span>
                            (<?php echo $book['discount_percentage']; ?>% OFF)
                        </p>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No books found for this author.</p>
        <?php endif; ?>
    </div>

</body>

</html>

<?php $conn->close(); ?>