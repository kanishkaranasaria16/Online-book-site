<?php
session_start();
$conn = new mysqli("localhost", "root", "", "bookvilla");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    $sql = "SELECT * FROM admin WHERE email='$email' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['user'] = $email;
        header("Location: dashboard.html");
        exit();
    } else {
        echo "<script>alert('Invalid Credentials'); window.location.href='index.html';</script>";
    }
}
?>
