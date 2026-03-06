<?php
include 'db.php';

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Check if fields are empty
    if (empty($name) || empty($email) || empty($password)) {
        $error = "All fields are required!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format!";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters long!";
    } else {
        // Check if email already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $error = "Email is already registered!";
        } else {
            // Hash password and insert new user
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $name, $email, $hashed_password);

            if ($stmt->execute()) {
                $success = "Registration successful! Redirecting to login...";
                echo "<script>
                    setTimeout(function() {
                        window.location.href = 'login.html';
                    }, 2000);
                </script>";
            } else {
                $error = "Registration failed. Please try again later!";
            }
        }
        $stmt->close();
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Bookscape</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <div class="right-section">
            <h2>Sign Up</h2>

            <!-- Show error message -->
            <?php if (!empty($error)) : ?>
                <p class="error-msg"><?php echo $error; ?></p>
                <a href="register.html" class="retry-btn">Try Again</a>
            <?php endif; ?>

            <!-- Show success message -->
            <?php if (!empty($success)) : ?>
                <p class="success-msg"><?php echo $success; ?></p>
            <?php else: ?>
                <form action="register.php" method="POST" class="form-box">
                    <div class="input-group">
                        <input type="text" name="name" class="input-field" placeholder="Full Name" required>
                        <input type="email" name="email" class="input-field" placeholder="Email address" required>
                        <input type="password" name="password" class="input-field" placeholder="Password" required>
                        <button type="submit" class="submit-btn">Sign Up</button>
                    </div>
                </form>
            <?php endif; ?>

            <p class="or-text">Or</p>
            <div class="button-box">
                <button class="toggle-btn">Google</button>
                <button class="toggle-btn">Apple</button>
            </div>
            <p>Already have an account? <a href="login.html" class="link">Login</a></p>
        </div>
    </div>
</body>
</html>
