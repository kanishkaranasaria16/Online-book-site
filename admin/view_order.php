<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bookvilla";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$order_id = $_GET['id'];
$sql = "SELECT * FROM orders WHERE order_id = $order_id";
$result = $conn->query($sql);
$order = $result->fetch_assoc();
$order_items_sql = "SELECT * FROM order_items WHERE order_id = $order_id";
$order_items_result = $conn->query($order_items_sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Order Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f9f9f9;
            padding: 20px;
        }

        h2,
        h3 {
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background: #f8f8f8;
        }

        .order-items {
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        .btn {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 15px;
            text-decoration: none;
            background-color: #28a745;
            color: white;
            border-radius: 5px;
            text-align: center;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>Order Details</h2>

        <label>Order ID</label>
        <input type="text" value="<?php echo $order['order_id']; ?>" readonly>

        <label>Name</label>
        <input type="text" value="<?php echo $order['name']; ?>" readonly>

        <label>Phone</label>
        <input type="text" value="<?php echo $order['phone']; ?>" readonly>

        <label>Address</label>
        <input type="text" value="<?php echo $order['address']; ?>" readonly>

        <label>Payment Method</label>
        <input type="text" value="<?php echo $order['payment_method']; ?>" readonly>

        <label>Total Items</label>
        <input type="text" value="<?php echo $order['total_items']; ?>" readonly>

        <label>Total Price</label>
        <input type="text" value="<?php echo $order['total_price']; ?>" readonly>

        <div class="order-items">
            <h3>Ordered Items</h3>
            <table>
                <tr>
                    <th>Book Name</th>
                    <th>Quantity</th>
                </tr>
                <?php while ($item = $order_items_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $item['book_name']; ?></td>
                        <td><?php echo $item['quantity']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>

        <a class="btn" href="order.php">Back to Orders</a>
    </div>

</body>

</html>

<?php $conn->close(); ?>