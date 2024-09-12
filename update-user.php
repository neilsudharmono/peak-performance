<?php
// Start session and check if user is logged in
session_start();
if (!isset($_SESSION["email"])) {
    header("Location: login.php");
    exit();
}

// DB connection settings
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "peakperformance";
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

    // Basic validation
    if (empty($firstName) || empty($lastName) || empty($phone)) {
        echo "<script>alert('Please fill all required fields.');</script>";
    } else {
        // Check if the user wants to change the password
        if (!empty($newPassword) || !empty($confirmNewPassword)) {
            // Ensure current password is entered and valid
            if (empty($currentPassword)) {
                echo "<script>alert('Please enter your current password to change the password.'); window.location.href = 'update-user.php';</script>";
                exit(); // Stop further execution
            } elseif (
                !password_verify($currentPassword, $currentPasswordHash)
            ) {
                echo "<script>alert('Current password is incorrect.'); window.location.href = 'update-user.php';</script>";
                exit(); // Stop further execution
            } elseif ($newPassword !== $confirmNewPassword) {
                echo "<script>alert('New passwords do not match.'); window.location.href = 'update-user.php';</script>";
                exit(); // Stop further execution
            } else {
                // Update the password in the database
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                $sql = "UPDATE Users SET PasswordHash = ? WHERE Email = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ss", $hashedPassword, $email);
                $stmt->execute();
                echo "<script>alert('Password has been updated successfully!');</script>";
            }
        }

        // Update user information in the database
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
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User Information | Peak Performance Sports Club</title>
    <link rel="icon" type="image/x-icon" href="/img/favicon.ico">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/image-header-no-title.css">
    <link rel="stylesheet" href="css/page-info.css">
    <link rel="stylesheet" href="css/info-cta.css">
    <link rel="stylesheet" href="css/login.css">
    <style>
        header {
            background-color: #084149;
            padding: 10px 0;
            font-size: 16px;
            position: fixed;
            width: 100%;
            z-index: 1000;
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
                ); ?>" required aria-required="true" aria-describedby="first-name-error">
                <span id="first-name-error" class="error-message"></span>
            </div>
            <div class="form-group">
                <label for="last-name">Last Name</label>
                <input type="text" id="last-name" name="last-name" value="<?php echo htmlspecialchars(
                    $lastName
                ); ?>" required aria-required="true" aria-describedby="last-name-error">
                <span id="last-name-error" class="error-message"></span>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars(
                    $email
                ); ?>" disabled><br>
            </div>
            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars(
                    $phone
                ); ?>" required aria-required="true" aria-describedby="phone-error" pattern="[0-9]{10}">
                <span id="phone-error" class="error-message"></span>
            </div>

            <!-- Password Update Section -->
            <div class="form-group">
                <label for="current-password">Current Password</label>
                <input type="password" id="current-password" name="current-password" aria-describedby="current-password-error">
                <span id="current-password-error" class="error-message"></span>
            </div>
            <div class="form-group">
                <label for="new-password">New Password</label>
                <input type="password" id="new-password" name="new-password" aria-describedby="new-password-error">
                <span id="new-password-error" class="error-message"></span>
            </div>
            <div class="form-group">
                <label for="confirm-new-password">Confirm New Password</label>
                <input type="password" id="confirm-new-password" name="confirm-new-password" aria-describedby="confirm-new-password-error">
                <span id="confirm-new-password-error" class="error-message"></span>
            </div>

            <button type="submit" name="update">Update</button>
        </form>
    </main>

    <?php include "footer.php"; ?>
</body>
</html>
