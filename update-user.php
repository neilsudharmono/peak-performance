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

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update"])) {
    // Sanitize input
    $firstName = htmlspecialchars(trim($_POST["first-name"]));
    $lastName = htmlspecialchars(trim($_POST["last-name"]));
    $phone = htmlspecialchars(trim($_POST["phone"]));

    // Check if any field is empty (basic validation)
    if (empty($firstName) || empty($lastName) || empty($phone)) {
        echo "<script>alert('Please fill all required fields.');</script>";
    } else {
        // Update user information in the database
        $email = $_SESSION["email"];
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

// Fetch user information to pre-fill the form
$email = $_SESSION["email"];
$sql = "SELECT FirstName, LastName, PhoneNumber FROM Users WHERE Email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($firstName, $lastName, $phone);
$stmt->fetch();
$stmt->close();
$conn->close();
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
            position: relative;
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
                    $_SESSION["email"]
                ); ?>" disabled><br>
            </div>
            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars(
                    $phone
                ); ?>" required aria-required="true" aria-describedby="phone-error" pattern="[0-9]{10}">
                <span id="phone-error" class="error-message"></span>
            </div>
            <button type="submit" name="update">Update</button>
        </form>
    </main>

    <?php include "footer.php"; ?>
</body>
</html>
