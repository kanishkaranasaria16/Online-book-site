<?php
$servername = "localhost";
$username = "root";
$password = ""; 
$database = "bookvilla";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
<?php
$sql = "SELECT * FROM admin"; 
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .profile-container {
            width: 50%;
            margin: auto;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>

<div class="profile-container">
    <h2>Admin Profile</h2>
    <?php if ($result->num_rows > 0): 
        $row = $result->fetch_assoc(); ?>
        <table>
            <tr>
                <th>Name</th>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
            </tr>
            <tr>
                <th>ID</th>
                <td><?php echo htmlspecialchars($row['id']); ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
            </tr>
            <tr>
                <th>Phone Number</th>
                <td><?php echo htmlspecialchars($row['phonenumber']); ?></td>
            </tr>
            <tr>
                <th>Password</th>
                <td><?php echo htmlspecialchars($row['password']); ?></td>
            </tr>
            <tr>
                <th>Address</th>
                <td><?php echo htmlspecialchars($row['address']); ?></td>
            </tr>
        </table>
    <?php else: ?>
        <p>No admin data found.</p>
    <?php endif; ?>
</div>

</body>
</html>

<?php $conn->close(); ?>
