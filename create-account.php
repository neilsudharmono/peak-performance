<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

// DB connection setting
$servername = "sql305.byetcluster.com";
$dbname = "if0_37303582_peakperformance";
$username = "if0_37303582";
$password = "nJs0p7Jfvt2";

// $servername = "localhost";
// $username = "root";
// $password = "root";
// $dbname = "peakperformance";

$conn = new mysqli($servername, $username, $password, $dbname);
$errors = [
    "firstName" => "",
    "lastName" => "",
    "phone" => "",
    "email" => "",
    "password" => "",
    "retypePassword" => "",
];

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Email duplication check via AJAX
if (isset($_POST["checkEmail"])) {
    $email = htmlspecialchars(trim($_POST["email"]));

    $sql = "SELECT * FROM Users WHERE Email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "exists";
    } else {
        echo "available";
    }

    $stmt->close();
    $conn->close();
    exit(); // Prevent further execution when using AJAX
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST["checkEmail"])) {
    $firstName = htmlspecialchars(trim($_POST["first-name"]));
    $lastName = htmlspecialchars(trim($_POST["last-name"]));
    $email = htmlspecialchars(trim($_POST["email"]));
    $password = htmlspecialchars(trim($_POST["password"]));
    $retypePassword = htmlspecialchars(trim($_POST["retype-password"]));
    $phone = htmlspecialchars(trim($_POST["phone"]));
    $securityQuestion = htmlspecialchars(trim($_POST["security-question"]));
    $securityAnswer = htmlspecialchars(trim($_POST["security-answer"]));

    // Validation for first name, last name, and phone number
    if (empty($firstName) || !preg_match("/^[a-zA-Z\s]+$/", $firstName)) {
        $errors["firstName"] =
            "First name must contain only letters and spaces.";
    }
    if (empty($lastName) || !preg_match("/^[a-zA-Z\s]+$/", $lastName)) {
        $errors["lastName"] = "Last name must contain only letters and spaces.";
    }
    if (empty($phone) || !preg_match("/^[0-9]{10}$/", $phone)) {
        $errors["phone"] = "Phone number must be a valid 10-digit number.";
    }
    if (empty($email)) {
        $errors["email"] = "Email is required.";
    }

    // Password check
    if ($password !== $retypePassword) {
        $errors["password"] = "Passwords do not match. Please try again.";
    }

    // If there are no errors, proceed with registration
    if (
        empty($errors["firstName"]) &&
        empty($errors["lastName"]) &&
        empty($errors["phone"]) &&
        empty($errors["email"]) &&
        empty($errors["password"])
    ) {
        // Hashed password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // SQL query to insert new user
        $sql = "INSERT INTO Users (FirstName, LastName, Email, PhoneNumber, RoleID, PasswordHash, SecurityQuestion, SecurityAnswer)
            VALUES (?, ?, ?, ?, 1, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            "sssssss",
            $firstName,
            $lastName,
            $email,
            $phone,
            $hashedPassword,
            $securityQuestion,
            $securityAnswer
        );

        if ($stmt->execute()) {
            echo "<script>alert('Registration successful'); window.location.href='login.php';</script>";
        } else {
            echo "<script>alert('Registration failed. Please try again.');</script>";
        }

        $stmt->close();
    } else {
        // Print errors
        foreach ($errors as $error) {
            if (!empty($error)) {
                echo "<script>alert('" . $error . "');</script>";
            }
        }
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Sign up to become a member of Peak Performance Sports Club. Join now to access exclusive sports facilities and events.">
    <meta name="keywords" content="Peak Performance Sports Club, sign up, membership, tennis, lawn bowl, sports club">
    <meta name="robots" content="index, follow">
    <meta name="author" content="Peak Performance Sports Club">
    <meta name="theme-color" content="#084149">
    <link rel="icon" type="image/x-icon" href="/peak-performance/img/favicon1.png" />
    <title>Sign up | Peak Performance Sports Club</title>
    <link rel="stylesheet" href="css/header.css?v=1.0" />
    <link rel="stylesheet" href="css/footer.css" />
    <link rel="stylesheet" href="css/login.css" />
    <link rel="stylesheet" href="css/create-account.css" />
    
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

    <main class="login-container">
        <form class="login-form" id="sign-up-form" action="#" method="POST" novalidate>
            <h1>Sign Up</h1>
            <div class="form-group">
                <label for="first-name">First Name</label>
                <input type="text" id="first-name" name="first-name" required aria-required="true" aria-describedby="first-name-error" />
                <span id="first-name-error" class="error-message"></span>
            </div>
            <div class="form-group">
                <label for="last-name">Last Name</label>
                <input type="text" id="last-name" name="last-name" required aria-required="true" aria-describedby="last-name-error" />
                <span id="last-name-error" class="error-message"></span>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required aria-required="true" aria-describedby="email-error" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" />
                <button type="button" id="check-email-button">Check Email</button>
                <span id="email-status" class="email-status"></span>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required aria-required="true" aria-describedby="password-error" />
                <span id="password-error" class="error-message"></span>
            </div>
            <div class="form-group">
                <label for="retype-password">Retype Password</label>
                <input type="password" id="retype-password" name="retype-password" required aria-required="true" aria-describedby="retype-password-error" />
                <span id="retype-password-error" class="error-message"></span>
            </div>
            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="tel" id="phone" name="phone" required aria-required="true" aria-describedby="phone-error" pattern="[0-9]{10}" />
                <span id="phone-error" class="error-message"></span>
            </div>
            <!-- Security Question Selection -->
            <div class="form-group">
                <label for="security-question">Security Question</label>
                <select id="security-question" name="security-question" required aria-required="true">
                    <option value="">Select a Security Question</option>
                    <option value="What is your pet name?">What is your pet's name?</option>
                    <option value="What is your mother maiden name?">What is your mother's maiden name?</option>
                    <option value="What was the name of your first school?">What was the name of your first school?</option>
                    <option value="What is your favorite color?">What is your favorite color?</option>
                </select>
            </div>
            <div class="form-group">
                <label for="security-answer">Your Answer</label>
                <input type="text" id="security-answer" name="security-answer" required aria-required="true" aria-describedby="security-answer-error" />
                <span id="security-answer-error" class="error-message"></span>
            </div>
            <button type="submit">Sign Up</button>
            <a href="login.php" class="back-to-login-link">Back to Login</a>
        </form>
    </main>

    <?php include "footer.php"; ?>

    <script src="scripts/script.js"></script>
    <script src="scripts/register.js"></script>
    <script src="scripts/login.js"></script>

</body>
</html>
