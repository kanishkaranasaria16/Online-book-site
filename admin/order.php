<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #d3d3d3;
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

        .status-select {
            padding: 5px;
            border-radius: 4px;
            border-radius: 20px;
            font-size: 16px;
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

        .delete-btn {
            border: none;
            outline: none;
            cursor: pointer;
        }
    </style>
</head>

<body>
<?php include 'navbar.html'; ?>
<div class="content">
    <h2>Orders List</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Phone</th>
            <th>Address</th>
            <th>Payment Method</th>
            <th>Total Items</th>
            <th>Total Price</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "bookvilla";

        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $limit = 10;
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $start = ($page - 1) * $limit;

        $sql = "SELECT * FROM orders LIMIT $start, $limit";
        $result = $conn->query($sql);

        $total_query = "SELECT COUNT(order_id) FROM orders";
        $total_result = $conn->query($total_query);
        $total_row = $total_result->fetch_row();
        $total_pages = ceil($total_row[0] / $limit);

        while ($row = $result->fetch_assoc()):
        ?>
            <tr>
                <td><?php echo $row['order_id']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['phone']; ?></td>
                <td><?php echo $row['address']; ?></td>
                <td><?php echo $row['payment_method']; ?></td>
                <td><?php echo $row['total_items']; ?></td>
                <td><?php echo $row['total_price']; ?></td>
                <td>
                    <select class="status-select" data-id="<?php echo $row['order_id']; ?>">
                        <option value="Pending" <?php if ($row['status'] == 'Pending') echo 'selected'; ?>>Pending</option>
                        <option value="Completed" <?php if ($row['status'] == 'Completed') echo 'selected'; ?>>Completed</option>
                        <option value="Cancelled" <?php if ($row['status'] == 'Cancelled') echo 'selected'; ?>>Cancelled</option>
                    </select>
                </td>
                <td>
                    <a class="btn view-btn" href="view_order.php?id=<?php echo $row['order_id']; ?>"><i class="fas fa-eye action-icon view-icon"></i></a>
                    <button class="delete-btn" onclick="deleteOrder(<?php echo $row['order_id']; ?>)"><i class="fas fa-trash-alt action-icon delete-icon"></i></button>
                    </a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>
    <div class="pagination">
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <a href="order.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
        <?php endfor; ?>
    </div>

    <script>
        $(document).ready(function() {
            $(".status-select").change(function() {
                var orderId = $(this).data("id");
                var newStatus = $(this).val();

                $.ajax({
                    url: "update_status.php",
                    type: "POST",
                    data: {
                        id: orderId,
                        status: newStatus
                    },
                    success: function(response) {
                        alert("Order status updated successfully!");
                    },
                    error: function() {
                        alert("Failed to update order status.");
                    }
                });
            });
        });

        function deleteOrder(orderId) {
            if (confirm("Are you sure you want to delete this order?")) {
                $.ajax({
                    url: "delete_order.php",
                    type: "POST",
                    data: {
                        id: orderId
                    },
                    success: function(response) {
                        if (response == "Success") {
                            alert("Order deleted successfully!");
                            $("#order_" + orderId).remove();
                        } else {
                            alert("Failed to delete order.");
                        }
                    }
                });
            }
        }
    </script>

</body>

</html>

<?php $conn->close(); ?>