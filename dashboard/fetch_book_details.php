<?php
include 'db.php';

if (isset($_GET['id'])) {
    $bookId = $_GET['id'];
    $query = "SELECT * FROM bestsellers WHERE id = '$bookId'";
    
    $result = mysqli_query($conn, $query);
    
    if ($row = mysqli_fetch_assoc($result)) {
        echo json_encode($row);
    } else {
        echo json_encode(["error" => "Book not found"]);
    }
}

mysqli_close($conn);
?>
