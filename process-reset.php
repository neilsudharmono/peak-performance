<?php
session_start();

// Redirect if email is not set
if (!isset($_SESSION["reset_email"])) {
    header("Location: forgot-password.php");
    exit();
}

// Database connection
$servername = 'sql305.byetcluster.com';  
$dbname = 'if0_37303582_peakperformance';  
$username = 'if0_37303582';  
$password = 'nJs0p7Jfvt2'; 

/*
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "peakperformance";
*/

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$passwordError = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newPassword = htmlspecialchars(trim($_POST["new-password"]));
    $confirmPassword = htmlspecialchars(trim($_POST["confirm-password"]));

    // Password validation: min 8 chars, 1 uppercase, 1 special character
    if ($newPassword === $confirmPassword) {
        if (
            preg_match('/^(?=.*[A-Z])(?=.*[!@#$%^&*])(?=.{8,})/', $newPassword)
        ) {
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
            $passwordError =
                "Password must be at least 8 characters, contain at least one capital letter, and one special character.";
        }
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
    <meta name="description" content="Reset your password at Peak Performance Sports Club. Securely update your credentials and regain access to your account.">
    <meta name="keywords" content="Password Reset, Peak Performance Sports Club, Account Recovery, Secure Login">
    <meta name="robots" content="noindex, nofollow">
    <meta name="author" content="Peak Performance Sports Club">
    <meta name="theme-color" content="#084149">
    <link rel="icon" type="image/x-icon" href="/peak-performance/img/favicon1.png" />
    <link rel="stylesheet" href="css/header.css" />
    <link rel="stylesheet" href="css/footer.css" />
    <link rel="stylesheet" href="css/login.css" />
    <link rel="stylesheet" href="css/forgot-password.css" />
    <title>Reset Password | Peak Performance Sports Club</title>
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
    <script src="scripts/login.js"></script>
    <script src="scripts/register.js"></script>
</body>
</html>
