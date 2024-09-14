<?php
// Set the session cookie lifetime (time before the browser deletes the session cookie)
ini_set("session.cookie_lifetime", 3600); // 1 hour

// Set the maximum time in seconds before a session expires if not used
ini_set("session.gc_maxlifetime", 3600); // 1 hour

// Database connection settings
$servername = "sql305.byetcluster.com";
$dbname = "if0_37303582_peakperformance";
$username = "if0_37303582";
$password = "nJs0p7Jfvt2";

// $servername = "localhost";
// $username = "root";
// $password = "root";
// $dbname = "peakperformance";

try {
    // Create a new PDO connection
    $conn = new PDO(
        "mysql:host=$servername;port=$port;dbname=$dbname",
        $username,
        $password
    );
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $email = htmlspecialchars(trim($_POST["email"]));
    $password = htmlspecialchars(trim($_POST["password"]));

    // Prepare the SQL statement to prevent SQL injection
    $sql =
        "SELECT UserID, FirstName, LastName, PasswordHash, RoleID FROM Users WHERE Email = :email";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":email", $email, PDO::PARAM_STR);
    $stmt->execute();

    // Check if the user exists
    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $userID = $row["UserID"];
        $firstName = $row["FirstName"];
        $lastName = $row["LastName"];
        $passwordHash = $row["PasswordHash"];
        $roleID = $row["RoleID"];

        // Verify the password
        if (password_verify($password, $passwordHash)) {
            // Password is correct, set session variables
            session_start();
            $_SESSION["user_id"] = $userID;
            $_SESSION["first_name"] = $firstName;
            $_SESSION["last_name"] = $lastName;
            $_SESSION["email"] = $email;
            $_SESSION["role"] = $roleID;

            echo "<script>alert('SUCCESS');</script>";

            // Redirect to a dashboard or homepage
            if ($roleID == 1) {
                header("Location: member-page.php");
            } else {
                header("Location: staff-events-page.php");
            }
            exit();
        } else {
            // Password is incorrect
            echo "<script>alert('Incorrect password. Please try again.');</script>";
        }
    } else {
        // User not found
        echo "<script>alert('No user found with that email. Please try again.');</script>";
    }

    // Close the connection
    $conn = null;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Login to Peak Performance Sports Club to access your account and enjoy the exclusive benefits our community offers.">
    <meta name="keywords" content="Login, Peak Performance Sports Club, sports club, member login, access account, exclusive benefits">
    <meta name="robots" content="index, follow">
    <meta name="author" content="Peak Performance Sports Club">
    <meta name="theme-color" content="#084149">
    <link rel="icon" type="image/x-icon" href="/peak-performance/img/favicon1.png" />
    <link rel="stylesheet" href="css/header.css?v=1.0" />
    <link rel="stylesheet" href="css/footer.css" />
    <link rel="stylesheet" href="css/login.css" />
    <title>Login | Peak Performance Sports Club</title>

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
    <main class="login-container" role="main">
      <form
        class="login-form"
        id="login-form"
        action=""
        method="POST"
        novalidate
      >
        <h1>Login</h1>
        <div class="form-group">
          <label for="email">Email</label>
          <input
            type="email"
            id="email"
            name="email"
            required
            aria-required="true"
            aria-describedby="email-error"
            pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
          />
          <span id="email-error" class="error-message"></span>
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input
            type="password"
            id="password"
            name="password"
            required
            aria-required="true"
            aria-describedby="password-error"
          />
          <span id="password-error" class="error-message"></span>
        </div>
        <a href="forgot-password.php" class="forgot-password-link"
          >Forgot your password?</a
        >
        <button type="submit">Sign in</button>
        <a class="create-account" href="create-account.php"
          >Don't have an account yet? Sign up now</a
        >
      </form>
    </main>

    <!-- Footer -->
    <?php include "footer.php"; ?>
  </body>
  <script src="scripts/script.js"></script>
  <script src="scripts/login.js"></script>
</html>
