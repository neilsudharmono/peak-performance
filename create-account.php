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
    </style>
  </head>
  <body>
    <!-- Header -->
    <?php include 'header.php'; ?>

    <main class="login-container">
      <form
        class="login-form"
        id="sign-up-form"
        action="#"
        method="POST"
        novalidate
      >
        <h1>Sign Up</h1>
        <div class="form-group">
          <label for="first-name">First Name</label>
          <input
            type="text"
            id="first-name"
            name="first-name"
            required
            aria-required="true"
            aria-describedby="first-name-error"
          />
          <span id="first-name-error" class="error-message"></span>
        </div>
        <div class="form-group">
          <label for="last-name">Last Name</label>
          <input
            type="text"
            id="last-name"
            name="last-name"
            required
            aria-required="true"
            aria-describedby="last-name-error"
          />
          <span id="last-name-error" class="error-message"></span>
        </div>
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
        <div class="form-group">
          <label for="retype-password">Retype Password</label>
          <input
            type="password"
            id="retype-password"
            name="retype-password"
            required
            aria-required="true"
            aria-describedby="retype-password-error"
          />
          <span id="retype-password-error" class="error-message"></span>
        </div>
        <div class="form-group">
          <label for="phone">Phone Number</label>
          <input
            type="tel"
            id="phone"
            name="phone"
            required
            aria-required="true"
            aria-describedby="phone-error"
            pattern="[0-9]{10}"
          />
          <span id="phone-error" class="error-message"></span>
        </div>
        <div class="form-group">
          <label for="dob">Date of Birth</label>
          <input
            type="date"
            id="dob"
            name="dob"
            required
            aria-required="true"
            aria-describedby="dob-error"
          />
          <span id="dob-error" class="error-message"></span>
        </div>
        <button type="submit">Sign Up</button>
        <a href="login.php" class="back-to-login-link">Back to Login</a>
      </form>
    </main>

    <?php include 'footer.php'; ?>

  </body>
  <script src="scripts/script.js"></script>
  <script src="scripts/login.js"></script>
</html>
