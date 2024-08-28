<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Forgot Password | Peak Performance Sports Club</title>
    <link rel="icon" type="image/x-icon" href="/img/favicon.ico" />
    <link rel="stylesheet" href="css/header.css" />
    <link rel="stylesheet" href="css/footer.css" />
    <link rel="stylesheet" href="css/image-header-no-title.css" />
    <link rel="stylesheet" href="css/page-info.css" />
    <link rel="stylesheet" href="css/info-cta.css" />
    <link rel="stylesheet" href="css/login.css" />
    <style>
      header {
        background-color: #084149; /* Set this to the background color you want */
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
    <?php include 'header.php'; ?>

    <main class="login-container">
      <form
        class="login-form"
        id="forgot-password-form"
        action="#"
        method="POST"
        novalidate
      >
        <h1>Forgot Password</h1>
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
        <button type="submit">Send Reset Link</button>
        <a href="login.php" class="back-to-login-link">Back to Login</a>
      </form>
    </main>
    <?php include 'footer.php'; ?>

  </body>
  <script src="scripts/script.js"></script>
  <script src="scripts/login.js"></script>
</html>
