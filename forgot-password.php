<?php
// Start session
session_start();

// Database connection settings
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "peakperformance";

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
    <title>Forgot Password | Peak Performance Sports Club</title>
    <link rel="icon" type="image/x-icon" href="/img/favicon.ico" />
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

        .back-to-login-link {
            display: block;
            text-align: center;
            margin-top: 10px;
            color: #084149;
            text-decoration: none;
        }

        .back-to-login-link:hover {
            text-decoration: underline;
        }

        .error-message {
            color: red;
            font-size: 0.875em;
            text-align: center;
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
