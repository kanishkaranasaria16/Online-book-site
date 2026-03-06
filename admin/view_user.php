<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "bookvilla";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$sql = "SELECT * FROM users WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    die("User not found.");
}

$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Customer</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #d3d3d3;
            padding: 20px;
            text-align: center;
        }

        .container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 50%;
            margin: auto;
        }

        img {
            width: 150px;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
        }

        h2 {
            margin-top: 10px;
        }

        .details {
            text-align: left;
            margin-top: 20px;
        }

        .back-btn {
            padding: 10px 15px;
            background: orange;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
            width: 90%;
        }

        .back-btn:hover {
            background: rgb(255, 165, 0,0.8);
        }
    </style>
</head>
<body>
<div class="container">
    <h2><?= htmlspecialchars($row['name']); ?></h2>
    <div class="details">
        <p><strong>Email:</strong> <?= $row['email']; ?></p>
        <p><strong>Phone Number:</strong> <?= $row['phonenumber']; ?></p>
        <p><strong>Address:</strong> <?= $row['address']; ?></p>
        <p><strong>Order:</strong> <?= $row['order']; ?>%</p>
        <p><strong>Spend:</strong> <?= $row['spend']; ?></p>
    </div>
    <a href="user.php" class="back-btn">Back to List</a>
</div>

</body>
</html>

<?php $conn->close(); ?>
