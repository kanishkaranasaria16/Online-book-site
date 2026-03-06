<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "bookvilla";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM publishers WHERE publisher_id=$id");
$row = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];

    $sql = "UPDATE publishers SET name='$name', address='$address', contact='$contact', email='$email' WHERE publisher_id=$id";

    if ($conn->query($sql) === TRUE) {
        header("Location: publisher.php");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Publisher</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            margin: 20px;
        }

        .container {
            width: 50%;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px #ccc;
        }

        h2 {
            text-align: center;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-top: 10px;
            font-weight: bold;
        }

        input,
        textarea,
        button {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        button {
            background: green;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            margin-top: 15px;
        }

        button:hover {
            background: darkgreen;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>Edit Publisher</h2>
        <form method="POST">
            <label>Name:</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($row['name']); ?>" required>
            <label>Address:</label>
            <textarea name="address" required><?php echo htmlspecialchars($row['address']); ?></textarea>
            <label>Contact:</label>
            <input type="text" name="contact" value="<?php echo htmlspecialchars($row['contact']); ?>" required>
            <label>Email:</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($row['email']); ?>" required>
            <button type="submit">Update Publisher</button>
        </form>
    </div>

</body>

</html>