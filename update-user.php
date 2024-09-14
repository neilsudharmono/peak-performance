<?php
// Start session and check if user is logged in
session_start();
if (!isset($_SESSION["email"])) {
    header("Location: login.php");
    exit();
}

// DB connection settings
$servername = "sql305.byetcluster.com";
$dbname = "if0_37303582_peakperformance";
$username = "if0_37303582";
$password = "nJs0p7Jfvt2";

// $servername = "localhost";
// $username = "root";
// $password = "root";
// $dbname = "peakperformance";

$errors = [
    "firstName" => "",
    "lastName" => "",
    "phone" => "",
    "currentPassword" => "",
    "newPassword" => "",
    "confirmNewPassword" => "",
];

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user information to pre-fill the form
$email = $_SESSION["email"];
$sql =
    "SELECT FirstName, LastName, Email, PhoneNumber, PasswordHash FROM Users WHERE Email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($firstName, $lastName, $email, $phone, $currentPasswordHash);
$stmt->fetch();
$stmt->close();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update"])) {
    // Sanitize input
    $firstName = htmlspecialchars(trim($_POST["first-name"]));
    $lastName = htmlspecialchars(trim($_POST["last-name"]));
    $phone = htmlspecialchars(trim($_POST["phone"]));
    $currentPassword = htmlspecialchars(trim($_POST["current-password"]));
    $newPassword = htmlspecialchars(trim($_POST["new-password"]));
    $confirmNewPassword = htmlspecialchars(
        trim($_POST["confirm-new-password"])
    );

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

    // Password change validation
    if (!empty($newPassword) || !empty($confirmNewPassword)) {
        if (empty($currentPassword)) {
            $errors["currentPassword"] =
                "Please enter your current password to change the password.";
        } elseif (!password_verify($currentPassword, $currentPasswordHash)) {
            $errors["currentPassword"] = "Current password is incorrect.";
        } elseif ($newPassword !== $confirmNewPassword) {
            $errors["confirmNewPassword"] = "New passwords do not match.";
        } elseif (
            !preg_match(
                "/^(?=.*[A-Z])(?=.*[!@#$%^&*])(?=.*[0-9])(?=.{8,})/",
                $newPassword
            )
        ) {
            $errors["newPassword"] =
                "Password must be at least 8 characters, contain one uppercase letter, one number, and one special character.";
        } else {
            // Update the password in the database
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $sql = "UPDATE Users SET PasswordHash = ? WHERE Email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $hashedPassword, $email);
            $stmt->execute();
        }
    }

    // If no errors, update the user information in the database
    if (array_filter($errors) === []) {
        $sql =
            "UPDATE Users SET FirstName = ?, LastName = ?, PhoneNumber = ? WHERE Email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $firstName, $lastName, $phone, $email);

        if ($stmt->execute()) {
            // Update session variables with the new data
            $_SESSION["first_name"] = $firstName;
            $_SESSION["last_name"] = $lastName;
            $_SESSION["phone"] = $phone;

            // Success message and reload the page
            echo "<script>alert('Your information has been updated successfully!'); window.location.href = 'update-user.php';</script>";
        } else {
            echo "<script>alert('Error updating your information. Please try again.');</script>";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Update your personal information and password for the Peak Performance Sports Club. Manage your profile and contact details securely.">
    <meta name="keywords" content="Peak Performance Sports Club, user update, update profile, sports club, user information, update password">
    <meta name="robots" content="index, follow">
    <meta name="author" content="Peak Performance Sports Club">
    <meta name="theme-color" content="#084149">
    <title>Update User Information | Peak Performance Sports Club</title>
    <link rel="icon" type="image/x-icon" href="/peak-performance/img/favicon1.png" />
    <link rel="stylesheet" href="css/header.css?v=1.0" />
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/login.css">
    <style>
        header {
            background-color: #084149;
        }
        .login-container {
            margin-bottom:40px;
        }
        input#email:disabled {
            background-color: #e0e0e0; 
            color: #666; 
        }
        
    </style>
</head>
<body>
    <!-- Header -->
    <?php include "header.php"; ?>

    <main class="login-container">
    <form class="login-form" id="update-user-form" action="update-user.php" method="POST" novalidate>
    <h1>Update Your Information</h1>
    
    <div class="form-group">
        <label for="first-name">First Name</label>
        <input type="text" id="first-name" name="first-name" value="<?php echo htmlspecialchars(
            $firstName
        ); ?>" required>
        <span id="first-name-error" class="error-message"><?php echo $errors[
            "firstName"
        ]; ?></span>
    </div>
    
    <div class="form-group">
        <label for="last-name">Last Name</label>
        <input type="text" id="last-name" name="last-name" value="<?php echo htmlspecialchars(
            $lastName
        ); ?>" required>
        <span id="last-name-error" class="error-message"><?php echo $errors[
            "lastName"
        ]; ?></span>
    </div>
    
    <div class="form-group">
        <label for="email">Email</label>
        <!-- The email field is disabled, and its value comes from the session -->
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars(
            $email
        ); ?>" disabled>
        <span id="email-error" class="error-message"></span>
    </div>
    
    <div class="form-group">
        <label for="phone">Phone Number</label>
        <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars(
            $phone
        ); ?>" required pattern="[0-9]{10}">
        <span id="phone-error" class="error-message"><?php echo $errors[
            "phone"
        ]; ?></span>
    </div>

    <div class="form-group">
        <label for="current-password">Current Password</label>
        <input type="password" id="current-password" name="current-password">
        <span id="current-password-error" class="error-message"><?php echo $errors[
            "currentPassword"
        ]; ?></span>
    </div>
    
    <div class="form-group">
        <label for="new-password">New Password</label>
        <input type="password" id="new-password" name="new-password">
        <span id="new-password-error" class="error-message"><?php echo $errors[
            "newPassword"
        ]; ?></span>
    </div>
    
    <div class="form-group">
        <label for="confirm-new-password">Confirm New Password</label>
        <input type="password" id="confirm-new-password" name="confirm-new-password">
        <span id="confirm-new-password-error" class="error-message"><?php echo $errors[
            "confirmNewPassword"
        ]; ?></span>
    </div>

    <button type="submit" name="update">Update</button>
</form>

    </main>

    <?php include "footer.php"; ?>
    <script src="scripts/register.js"></script>
    <script src="scripts/login.js"></script>
</body>
</html>
