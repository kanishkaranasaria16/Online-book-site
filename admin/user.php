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
$result = $conn->query("SELECT COUNT(*) AS total FROM users");
$total_books = $result->fetch_assoc()['total'];
$total_pages = ceil($total_books / $limit);
$sql = "SELECT * FROM users LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $deleteQuery = "DELETE FROM users WHERE id = $id";
    if ($conn->query($deleteQuery) === TRUE) {
        echo "<script>alert('User deleted successfully!'); window.location='user.php';</script>";
    } else {
        echo "<script>alert('Error deleting User: " . $conn->error . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <title>Customer List</title>
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
    <h2>Customer List</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>NAME</th>
            <th>EMAIL</th>
            <th>PHONE NUMBER</th>
            <th>ADDRESS</th>
            <th>ORDER</th>
            <th>SPEND</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?= $row['id']; ?></td>
                <td><?= htmlspecialchars($row['name']); ?></td>
                <td><?= htmlspecialchars($row['email']); ?></td>
                <td><?= $row['phonenumber']; ?></td>
                <td><?= $row['address']; ?></td>
                <td><?= $row['order']; ?></td>
                <td>₹<?= $row['spend']; ?></td>
                <td class="action-buttons">
                    <a href="view_user.php?id=<?= $row['id']; ?>" title="View">
                        <i class="fas fa-eye action-icon view-icon"></i>
                    </a>
                    <a href="?delete=<?= $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this user?');" title="Delete">
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
</body>

</html>

<?php
$conn->close();
?>