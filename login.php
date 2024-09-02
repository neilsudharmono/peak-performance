<?php
// Set the session cookie lifetime (time before the browser deletes the session cookie)
ini_set("session.cookie_lifetime", 3600); // 1 hour

// Set the maximum time in seconds before a session expires if not used
ini_set("session.gc_maxlifetime", 3600); // 1 hour

session_start(); // Start the session

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $email = htmlspecialchars(trim($_POST["email"]));
    $password = htmlspecialchars(trim($_POST["password"]));

    // Prepare the SQL statement to prevent SQL injection
    $sql =
        "SELECT UserID, FirstName, LastName, PasswordHash FROM Users WHERE Email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // Check if the user exists
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($userID, $firstName, $lastName, $passwordHash);
        $stmt->fetch();

        // Verify the password
        if (password_verify($password, $passwordHash)) {
            // Password is correct, set session variables
            $_SESSION["user_id"] = $userID;
            $_SESSION["first_name"] = $firstName;
            $_SESSION["last_name"] = $lastName;
            $_SESSION["email"] = $email; // Store the email in the session

            // Redirect to a dashboard or homepage
            header("Location: member-page.php");
            exit();
        } else {
            // Password is incorrect
            echo "<script>alert('Incorrect password. Please try again.');</script>";
        }
    } else {
        // User not found
        echo "<script>alert('No user found with that email. Please try again.');</script>";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Peak Performance Sports Club</title>
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

    <footer>
      <div class="footer">
        <div class="footer-container">
          <div class="footer-row">
            <div class="footer-column">
              <p class="collapsible-header">
                <a href="about-us.php">About</a>
                <img src="img/down-arrow.png" alt="arrow" class="arrow-icon" />
              </p>
              <ul class="collapsible-content">
                <li><a href="function-article.php">Functions</a></li>
                <li><a href="membership.php">Membership</a></li>
                <li><a href="lawn-bowl-article.php">Bowl</a></li>
                <li><a href="tennis-article.php">Tennis</a></li>
              </ul>
            </div>
            <div class="footer-column">
              <p><a href="contact-us.php">Contact us</a></p>
              <ul>
                <li><a href="contact-us.php">Enquiry</a></li>
                <li>
                  <a href="#"
                    >Ground Floor and Level 1/59 Darby St, Cooks Hill NSW
                    2300</a
                  >
                </li>
                <li>Call Center</li>
                <li><a href="tel:+0240910500">(02) 4091 0500</a></li>
              </ul>
            </div>
            <div class="footer-column footer-right">
              <div>
                <img class="footer-flag" src="img/flag.webp" alt="Flag 1" />
                <img class="footer-logo" src="img/logo-color.png" alt="Logo" />
              </div>
              <p style="text-align: center; font-size: 12px">
                We acknowledge the Traditional Custodians of the land on which
                we work, live, and engage. We pay respect to Elders past and
                present.
              </p>
            </div>
          </div>
          <div class="footer-bottom">
            <div class="footer-bottom-content">
              <p style="font-size: 12px">
                &copy; 2024 Your Company Name. All rights reserved.
              </p>

              <div class="social-links">
                <ul>
                  <li>
                    <a href="facebook.com"
                      ><img
                        class="social-icon"
                        src="img/facebook.png"
                        alt="Facebook"
                    /></a>
                  </li>
                  <li>
                    <a href="x.com"
                      ><img class="social-icon" src="img/x.png" alt="X" />
                    </a>
                  </li>
                  <li>
                    <a href="instagram.com"
                      ><img
                        class="social-icon"
                        src="img/instagram.png"
                        alt="Instagram"
                      />
                    </a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </footer>
  </body>
  <script src="scripts/script.js"></script>
  <script src="scripts/login.js"></script>
</html>
