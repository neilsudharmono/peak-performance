<?php
// DB connection setting
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "peakperformance";

$conn = new mysqli($servername, $username, $password, $dbname);

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

    // Password check
    if ($password !== $retypePassword) {
        echo "<script>alert('Passwords do not match. Please try again.');</script>";
    } else {
        // HashedPassword
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // SQL with updated SecurityQuestion and SecurityAnswer
        $sql = "INSERT INTO Users (FirstName, LastName, Email, PhoneNumber, RoleID, PasswordHash, SecurityQuestion, SecurityAnswer)
            VALUES (?, ?, ?, ?, 1, ?, ?, ?)";

        // SQL execute
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
            // if success, show alert and shift to login.php
            echo "<script>
              alert('Registration successful');
              window.location.href='login.php';
          </script>";
        } else {
            // if fail, show alert
            echo "<script>alert('Registration not working. Please try again');</script>";
        }

        // close connection
        $stmt->close();
    }
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sign up | Peak Performance Sports Club</title>
    <link rel="icon" type="image/x-icon" href="/img/favicon.ico" />
    <link rel="stylesheet" href="css/header.css" />
    <link rel="stylesheet" href="css/footer.css" />
    <link rel="stylesheet" href="css/image-header-no-title.css" />
    <link rel="stylesheet" href="css/page-info.css" />
    <link rel="stylesheet" href="css/info-cta.css" />
    <link rel="stylesheet" href="css/login.css" />
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
        .email-status {
            font-size: 0.9em;
            margin-top: 5px;
            display: block;
        }
        .email-status.error {
            color: red;
        }
        .email-status.success {
            color: green;
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
                    <option value="What is your mother name?">What is your mother's maiden name?</option>
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
    <script src="scripts/login.js"></script>
    <script src="scripts/register.js"></script>
</body>
</html>
