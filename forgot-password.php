<?php
// Start session

// Database connection settings
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

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$emailError = ""; // Variable to store error message

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the email from form
    $email = htmlspecialchars(trim($_POST["email"]));

    // Check if email exists in the database
    $sql = "SELECT Email FROM Users WHERE Email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // If email exists, redirect to answer-user-question.php
    if ($stmt->num_rows > 0) {
        $_SESSION["reset_email"] = $email;
        header("Location: answer-user-question.php");
        exit();
    } else {
        // If email doesn't exist, show error message
        $emailError = "The email is not registered.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Forgot your password for Peak Performance Sports Club? Recover access to your account by submitting your registered email address.">
    <meta name="keywords" content="Peak Performance Sports Club, forgot password, reset password, user recovery, sports club">
    <meta name="robots" content="index, follow">
    <meta name="author" content="Peak Performance Sports Club">
    <meta name="theme-color" content="#084149">
    <link rel="icon" type="image/x-icon" href="/peak-performance/img/favicon1.png" />
    <title>Forgot Password | Peak Performance Sports Club</title>
    <link rel="stylesheet" href="css/header.css?v=1.0">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/forgot-password.css">

    <style>
      header {
        background-color: #084149; 
        padding: 10px 0;
        font-size: 16px;
        position: fixed;
        width: 100%;
        z-index: 1000;
        position: relative;
      }
      </style>
</head>
<body>
    <!-- Header -->
    <?php include "header.php"; ?>

    <!-- Main Content -->
    <main class="login-container">
        <form class="login-form" id="forgot-password-form" action="" method="POST" novalidate>
            <h1>Forgot Password</h1>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required aria-required="true" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" />
                <span id="email-error" class="error-message"><?php echo $emailError; ?></span>
            </div>
            <button type="submit">Submit</button>
            <a href="login.php" class="back-to-login-link">Back to Login</a>
        </form>
    </main>

    <!-- Footer -->
    <?php include "footer.php"; ?>

    <!-- Scripts -->
    <script src="scripts/validation.js"></script>
</body>
</html>
