<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "bookvilla";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT * FROM contacts ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reviews</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            width: 80%;
            margin: auto;
            padding: 20px;
            background: white;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            margin-top: 20px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        .contact-card {
            background: #ffffff;
            padding: 15px;
            margin: 10px 0;
            border-radius: 8px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }

        .contact-card h3 {
            margin: 0;
            color: #007BFF;
        }

        .contact-card p {
            margin: 5px 0;
            color: #555;
        }

        .contact-card .date {
            font-size: 12px;
            color: #999;
            text-align: right;
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
    <div class="container">
        <h2>Contact Messages</h2>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='contact-card'>";
                echo "<h3>" . htmlspecialchars($row['first_name']) . " " . htmlspecialchars($row['last_name']) . "</h3>";
                echo "<p><strong>Email:</strong> " . htmlspecialchars($row['email']) . "</p>";
                echo "<p><strong>Phone:</strong> " . htmlspecialchars($row['phone']) . "</p>";
                echo "<p><strong>Message:</strong> " . nl2br(htmlspecialchars($row['message'])) . "</p>";
                echo "<p class='date'>" . $row['created_at'] . "</p>";
                echo "</div>";
            }
        } else {
            echo "<p>No messages found.</p>";
        }
        $conn->close();
        ?>
    </div>
</div>
</body>

</html>