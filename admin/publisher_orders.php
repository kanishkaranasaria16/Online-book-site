<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "bookvilla";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$publisher_id = $_GET['id'];

$sql = "SELECT b.title AS book_title, 
               o.order_id, o.quantity, o.total_price, o.status, o.order_date
        FROM books b
        JOIN orders_db o ON b.id = o.id
        WHERE b.publisher_id = $publisher_id
        ORDER BY o.order_date DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Publisher Order Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            margin: 20px;
        }

        .container {
            width: 80%;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px #ccc;
        }

        h2 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }

        th {
            background: #007BFF;
            color: white;
        }

        td {
            background: #f9f9f9;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>Orders for Publisher ID: <?php echo $publisher_id; ?></h2>
        <table>
            <tr>
                <th>Book</th>
                <th>Order ID</th>
                <th>Quantity</th>
                <th>Total Price</th>
                <th>Status</th>
                <th>Order Date</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['book_title']; ?></td>
                    <td><?php echo $row['order_id']; ?></td>
                    <td><?php echo $row['quantity']; ?></td>
                    <td><?php echo $row['total_price']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                    <td><?php echo $row['order_date']; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>

</body>

</html>