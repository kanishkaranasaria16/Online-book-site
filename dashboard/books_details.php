<?php
$conn = new mysqli("localhost", "root", "", "bookvilla");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$book_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$book_query = "SELECT * FROM books WHERE id = $book_id";
$book_result = $conn->query($book_query);

if ($book_result->num_rows > 0) {
    $book = $book_result->fetch_assoc();
} else {
    die("Book not found.");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $book['title']; ?> - Book Details</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f8f9fa;
        }

        .container {
            max-width: 900px;
            margin: auto;
            display: flex;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            margin-top: 5%;
        }

        .book-image {
            width: 250px;
            height: auto;
            border-radius: 5px;
        }

        .details {
            flex: 1;
            padding-left: 20px;
        }

        .title {
            font-size: 22px;
            font-weight: bold;
        }

        .author {
            color: #007bff;
            font-size: 18px;
        }

        .price {
            font-size: 20px;
            font-weight: bold;
            color: #d9534f;
        }

        .original-price {
            text-decoration: line-through;
            color: gray;
            font-size: 16px;
        }

        .discount {
            color: green;
            font-size: 16px;
        }

        .stock {
            margin-top: 10px;
            font-size: 16px;
        }

        .description {
            margin-top: 10px;
            font-size: 16px;
            color: #333;
        }

        .buttons {
            margin-top: 15px;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            font-size: 16px;
            border-radius: 5px;
            width: 200px;
        }

        .add-to-cart {
            background-color: #d9534f;
            color: white;
        }

        .buy-now {
            background-color: white;
            color: #d9534f;
            border: 2px solid #d9534f;
        }

        .quantity {
            margin-top: 10px;
            display: flex;
            align-items: center;
        }

        .quantity button {
            padding: 5px 10px;
            border: 1px solid #ccc;
            background: #fff;
            cursor: pointer;
        }

        .quantity input {
            width: 40px;
            text-align: center;
            border: 1px solid #ccc;
        }

        .rating i {
            color: #f8d64e;
            font-size: 18px;
            margin-right: 3px;
        }
    </style>
</head>

<body>
    <?php include "navbar.html" ?>
    <div class="container">
        <img class="book-image" src="<?php echo $book['image_url']; ?>" alt="Book Image">
        <div class="details">
            <h1 class="title"><?php echo $book['title']; ?></h1>
            <p class="author"><?php echo $book['author']; ?></p>
            <p class="price">₹<span id="price"><?php echo $book['price']; ?></span>
                <span class="original-price">₹<span><?php echo $book['original_price']; ?></span></span>
                <span class="discount">(<?php echo $book['discount_percentage']; ?>% OFF)</span>
            </p>
            <p class="stock"><?php echo $book['stock'] > 0 ? "In Stock" : "Out of Stock"; ?></p>
            <p class="rating" id="rating">
                <?php
                $rating = round($book['rating']);
                for ($i = 1; $i <= 5; $i++) {
                    if ($i <= $rating) {
                        echo '<i class="fas fa-star"></i>';
                    } else {
                        echo '<i class="far fa-star"></i>';
                    }
                }
                ?>
            </p>
            <div class="quantity">
                <button onclick="changeQuantity(-1)">-</button>
                <input type="text" id="quantity" value="1" readonly>
                <button onclick="changeQuantity(1)">+</button>
            </div>
            <div class="buttons">
                <button class="btn add-to-cart" onclick="addToCart(<?php echo $book_id; ?>)">ADD TO CART</button>
                <button class="btn buy-now">BUY NOW</button>
                <p class="description"><?php echo $book['description']; ?></p>
            </div>
        </div>
    </div>

    <script>
        function addToCart(bookId) {
            let bookTitle = "<?php echo $book['title']; ?>";
            let bookPrice = <?php echo $book['price']; ?>;
            let bookImage = "<?php echo $book['image_url']; ?>";
            let quantity = parseInt(document.getElementById("quantity").value);

            let cart = JSON.parse(localStorage.getItem("cart")) || [];
            let existingBook = cart.find(item => item.book_id === bookId);

            if (existingBook) {
                existingBook.quantity += quantity;
            } else {
                cart.push({
                    book_id: bookId,
                    title: bookTitle,
                    price: bookPrice,
                    image: bookImage,
                    quantity: quantity
                });
            }

            localStorage.setItem("cart", JSON.stringify(cart));
            alert("Book added to cart!");
        }

        function changeQuantity(change) {
            let quantityInput = document.getElementById("quantity");
            let currentQuantity = parseInt(quantityInput.value);
            let newQuantity = currentQuantity + change;
            if (newQuantity >= 1) {
                quantityInput.value = newQuantity;
            }
        }
    </script>
</body>

</html>
<?php $conn->close(); ?>
