<?php
session_start();

// Redirect if email is not set in the session
if (!isset($_SESSION["reset_email"])) {
    header("Location: forgot-password.php");
    exit();
}

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
    <meta name="description" content="Answer the security question to reset your password at Peak Performance Sports Club. Secure your account and manage your profile with ease." />
    <meta name="keywords" content="Peak Performance Sports Club, security question, password reset, account recovery, user authentication, sports club" />
    <meta name="robots" content="index, follow" />
    <meta name="author" content="Peak Performance Sports Club" />
    <meta name="theme-color" content="#084149" />
    <link rel="icon" type="image/x-icon" href="/peak-performance/img/favicon1.png" />
    <title>Answer Security Question | Peak Performance Sports Club</title>
    <link rel="stylesheet" href="css/header.css?v=1.0" />
    <link rel="stylesheet" href="css/footer.css" />
    <link rel="stylesheet" href="css/login.css" />
</head>
<body>
    <!-- Header -->
    <?php include "header.php"; ?>

    <!-- Main Content -->
    <main class="login-container">
        <form class="login-form" id="answer-question-form" action="" method="POST" novalidate>
            <h1 style="color:#084149;margin-bottom:30px;">Security Question</h1>
            <h3 style="font-size: 1.2rem;color: #333;"><strong><?php echo htmlspecialchars(
                $securityQuestion
            ); ?></strong></h3>
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
