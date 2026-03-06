<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "bookvilla";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$limit = 10;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $limit;
$result = $conn->query("SELECT COUNT(*) AS total FROM books");
$total_books = $result->fetch_assoc()['total'];
$total_pages = ceil($total_books / $limit);
$sql = "SELECT * FROM books LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $deleteQuery = "DELETE FROM books WHERE id = $id";
    if ($conn->query($deleteQuery) === TRUE) {
        echo "<script>alert('Book deleted successfully!'); window.location='product.php';</script>";
    } else {
        echo "<script>alert('Error deleting book: " . $conn->error . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <title>Book List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #d3d3d3;
            margin: 20px;
            padding: 20px;
        }

        h2 {
            text-align: center;
            font-size: 36px;
            text-decoration: underline;
            font-family: 'Times New Roman', Times, serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        th,
        td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        td {
            border: none !important;
        }

        tr {
            border-bottom: none !important;
        }

        th {
            background-color: rgb(0, 0, 0);
            color: white;
        }

        tr:hover {
            background-color: whitesmoke;
            transition: 0.3s;
        }

        img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 5px;
        }

        .pagination {
            text-align: center;
            margin-top: 20px;
        }

        .pagination a {
            display: inline-block;
            padding: 10px 15px;
            margin: 5px;
            border-radius: 5px;
            background: rgb(79, 164, 255);
            color: white;
            text-decoration: none;
            transition: 0.3s;
            border-radius: 50px;
        }

        .pagination a:hover {
            background: #0056b3 !important;
        }

        .pagination a.active {
            background: rgb(79, 164, 255);
            ;
            font-weight: bold;
        }

        .edit-btn {
            padding: 8px 12px;
            background: #28a745;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        .update-btn {
            padding: 10px 15px;
            background: rgba(0, 87, 179, 0.8);
            color: white;
            border: none;
            cursor: pointer;
            display: block;
            margin: 20px auto;
            border-radius: 5px;
            width: 100%;
            height: 50px;
            font-size: 24px;
            font-family: Arial, Helvetica, sans-serif;
            border-radius: 50px;
        }

        .delete-btn {
            background: #dc3545;
            padding: 8px 12px;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .action-icon {
            font-size: 18px;
            padding: 8px;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
            transition: 0.3s;
        }

        .view-icon {
            background-color: rgba(0, 87, 179, 0.2);
            color: #007bff;
        }

        .edit-icon {
            color: #28a745;
            background-color: rgba(40, 167, 69, 0.2);
        }

        .delete-icon {
            color: #dc3545;
            background-color: rgba(220, 53, 69, 0.2);
        }

        .action-icon:hover {
            opacity: 0.6;
        }

        a {
            text-decoration: none;
        }

        .content {
            margin-left: 0;
            transition: margin-left 0.3s;
        }
    </style>
</head>

<body>
    <?php include 'navbar.html'; ?>
    <div class="content">
        <h2>Book List</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Image</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Original Price</th>
                <th>Discount %</th>
                <th>Rating</th>
                <th>Author</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?= $row['id']; ?></td>
                    <td><?= htmlspecialchars(mb_strimwidth($row['title'], 0, 50, '...')); ?></td>
                    <?php
                    $base_url = "http://localhost/kanishka/dashboard/";
                    $image_path = $base_url . str_replace('\\', '/', $row['image_url']);
                    ?>
                    <td>
                        <img src="<?= htmlspecialchars($image_path); ?>"
                            alt="title">
                    </td>
                    <td>₹<?= $row['price']; ?></td>
                    <td><?= $row['stock']; ?></td>
                    <td>₹<?= $row['original_price']; ?></td>
                    <td><?= $row['discount_percentage']; ?>%</td>
                    <td>
                        <?php
                        $rating = $row['rating'];
                        for ($i = 1; $i <= 5; $i++) {
                            if ($i <= $rating) {
                                echo '<i class="fas fa-star" style="color: gold;"></i>';
                            } elseif ($i - 0.5 == $rating) {
                                echo '<i class="fas fa-star-half-alt" style="color: gold;"></i>';
                            } else {
                                echo '<i class="far fa-star" style="color: gold;"></i>';
                            }
                        }
                        ?>
                    </td>
                    <td><?= htmlspecialchars($row['author']); ?></td>
                    <td><?= htmlspecialchars(mb_strimwidth($row['description'], 0, 50, '...')); ?></td>
                    <td class="action-buttons">
                        <a href="view.php?id=<?= $row['id']; ?>" title="View">
                            <i class="fas fa-eye action-icon view-icon"></i>
                        </a>
                        <a href="edit.php?id=<?= $row['id']; ?>" title="Edit">
                            <i class="fas fa-edit action-icon edit-icon"></i>
                        </a>
                        <a href="?delete=<?= $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this book?');" title="Delete">
                            <i class="fas fa-trash-alt action-icon delete-icon"></i>
                        </a>
                    </td>

                </tr>
            <?php } ?>
        </table>
        <div class="pagination">
            <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                <a href="?page=<?= $i; ?>" class="<?= ($i == $page) ? 'active' : ''; ?>"><?= $i; ?></a>
            <?php } ?>
        </div>
        <button class="update-btn" onclick="window.location.href='add_book.php'"><b>ADD BOOK</b></button>
    </div>
</body>

</html>

<?php
$conn->close();
?>