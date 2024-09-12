<?php
session_start();

// Redirect if email is not set
if (!isset($_SESSION["reset_email"])) {
    header("Location: forgot-password.php");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "peakperformance";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$passwordError = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newPassword = htmlspecialchars(trim($_POST["new-password"]));
    $confirmPassword = htmlspecialchars(trim($_POST["confirm-password"]));

    if ($newPassword === $confirmPassword) {
        // Hash the new password
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Update password in the database using email from session
        $email = $_SESSION["reset_email"];
        $sql = "UPDATE Users SET PasswordHash = ? WHERE Email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $hashedPassword, $email);

        if ($stmt->execute()) {
            echo "<script>alert('Password updated successfully!'); window.location.href = 'login.php';</script>";
        } else {
            $passwordError = "Error updating password. Please try again.";
        }

        $stmt->close();
    } else {
        $passwordError = "Passwords do not match.";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | Peak Performance Sports Club</title>
    <link rel="stylesheet" href="css/header.css" />
    <link rel="stylesheet" href="css/footer.css" />
    <link rel="stylesheet" href="css/login.css" />
    <style>
        header {
            background-color: #084149;
            padding: 10px 0;
            font-size: 16px;
            width: 100%;
            position: fixed;
            z-index: 1000;
        }

        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 80vh;
        }

        .login-form {
            width: 100%;
            max-width: 400px;
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        .login-form h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #084149;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #084149;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0b5b62;
        }

        .error-message {
            color: red;
            font-size: 0.875em;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <?php include "header.php"; ?>

    <!-- Main Content -->
    <main class="login-container">
        <form class="login-form" action="" method="POST">
            <h1>Reset Your Password</h1>
            <div class="form-group">
                <label for="new-password">New Password</label>
                <input type="password" id="new-password" name="new-password" required>
            </div>
            <div class="form-group">
                <label for="confirm-password">Confirm Password</label>
                <input type="password" id="confirm-password" name="confirm-password" required>
            </div>
            <span class="error-message"><?php echo $passwordError; ?></span>
            <button type="submit">Reset Password</button>
        </form>
    </main>

    <!-- Footer -->
    <?php include "footer.php"; ?>
</body>
</html>
