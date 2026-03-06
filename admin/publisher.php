<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "bookvilla";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$result = $conn->query("SELECT * FROM publishers");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Manage Publishers</title>
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
            background: black;
            color: white;
        }

        td {
            background: #f9f9f9;
        }

        .btn {
            display: block;
            width: 80%;
            margin: auto !important;
            text-align: center;
            text-decoration: none;
            padding: 10px 0;
            color: white;
            background: green;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            margin-top: 10px;
            font-size: 18px;
        }
        .btnn{
            text-decoration: none;
            padding: 5px 10px;
            color: white;
            background: green;
            border-radius: 5px;
        }
        .edit-btn {
            background: orange;
        }

        .delete-btn {
            background: red;
        }

        .content {
            margin-left: 0;
            transition: margin-left 0.3s;
        }
    </style>
</head>

<body>
    <?php include 'navbar.html'; ?>
    <br>
    <div class="content">
        <div class="container">
            <h2>Manage Publishers</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Contact</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['publisher_id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['address']; ?></td>
                        <td><?php echo $row['contact']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td>
                            <a href="edit_publisher.php?id=<?php echo $row['publisher_id']; ?>" class="btnn edit-btn">Edit</a>
                            <a href="delete_publisher.php?id=<?php echo $row['publisher_id']; ?>" class="btnn delete-btn" onclick="return confirm('Are you sure?');">Delete</a>
                            <a href="publisher_orders.php?id=<?php echo $row['publisher_id']; ?>" class="btnn">View Orders</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
            <br>
            <a href="add_publisher.php" class="btn">Add Publisher</a>
        </div>
    </div>
</body>

</html>