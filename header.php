<?php
header(
    "Cache-Control: no-store, no-cache, must-revalidate, max-age=0, post-check=0, pre-check=0",
    false
);
header("Pragma: no-cache");

session_start();

// Check if the user is logged in
$isLoggedIn = false;
$firstName = "";
$userID = "";

if (isset($_SESSION["first_name"])) {
    $isLoggedIn = true;
    $firstName = $_SESSION["first_name"];
    $userID = $_SESSION["user_id"];
}
?>

<header>
  <nav class="header-content">
    <a href="index.php">
      <img
        id="logo-header"
        src="img/logo-white.png"
        alt="Peak Performance Sport Club"
      />
    </a>
    <div
      class="hamburger"
      id="hamburger-menu"
      aria-expanded="false"
      aria-controls="nav-menu"
    >
      <span></span>
      <span></span>
      <span></span>
    </div>
    <div class="nav-menu" id="nav-menu" role="menu">
      <ul>
        <li><a href="latest-events.php">Our events</a></li>
        <li><a href="tennis-article.php">Tennis</a></li>
        <li><a href="lawn-bowl-article.php">Lawn Bowl</a></li>
        <li><a href="function-article.php">Function</a></li>
      </ul>

     <div class="header-desktop-button">
       <?php if ($isLoggedIn): ?>
          <span class="welcome-message"><a href="member-page.php">Welcome, <?php echo htmlspecialchars(
              $firstName
          ); ?>!</a></span>
          <a href="logout.php"><button>Logout</button></a>
        <?php else: ?>
          <a href="login.php"><button>Sign up / Login</button></a>
        <?php endif; ?>
      </div>
    </div>
  </nav>
</header>
