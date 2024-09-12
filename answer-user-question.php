<?php
session_start();

// Redirect if email is not set in the session
if (!isset($_SESSION["reset_email"])) {
    header("Location: forgot-password.php");
    exit();
}

// Database connection settings
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "peakperformance";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$answerError = "";
$securityQuestion = "";

// Fetch the security question from the database
$email = $_SESSION["reset_email"];
$sql = "SELECT SecurityQuestion, SecurityAnswer FROM Users WHERE Email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($securityQuestion, $correctAnswer);
$stmt->fetch();
$stmt->close();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $answer = htmlspecialchars(trim($_POST["answer"]));

    // Compare the user input answer with the stored answer
    if ($answer === $correctAnswer) {
        // Correct answer, redirect to password reset page
        header("Location: process-reset.php");
        exit();
    } else {
        // Incorrect answer, show error message
        $answerError =
            "The answer you provided is incorrect. Please try again.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Answer Security Question | Peak Performance Sports Club</title>
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
        <form class="login-form" id="answer-question-form" action="" method="POST" novalidate>
            <h1>Security Question</h1>
            <p><strong><?php echo htmlspecialchars(
                $securityQuestion
            ); ?></strong></p>
            <div class="form-group">
                <label for="answer">Your Answer</label>
                <input type="text" id="answer" name="answer" required aria-required="true">
                <span class="error-message"><?php echo $answerError; ?></span>
            </div>
            <button type="submit">Submit</button>
        </form>
    </main>

    <!-- Footer -->
    <?php include "footer.php"; ?>
</body>
</html>
