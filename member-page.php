<?php
// Start the session to access session variables
session_start();

// Ensure the user is logged in before displaying the page
if (!isset($_SESSION["first_name"])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

$firstName = $_SESSION["first_name"];
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Latest Events | Peak Performance Sports Club</title>
    <link rel="icon" type="image/x-icon" href="/img/favicon.ico" />
    <link rel="stylesheet" href="css/header.css" />
    <link rel="stylesheet" href="css/footer.css" />
    <link rel="stylesheet" href="css/image-header-no-title.css" />
    <link rel="stylesheet" href="css/page-info.css" />
    <link rel="stylesheet" href="css/member-page.css" />
    <link rel="stylesheet" href="css/filtering.css" />

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
      .update-button {
        background-color: #084149;
        color: #fff;
        border: none;
        padding: 4px 16px 0px;
        cursor: pointer;
        font-size: 16px;
        margin-left: 10px;
      }
      .update-button:hover {
        background-color: #06383d;
      }
    </style>
  </head>
  <body>
    <!-- Header -->
    <?php include "header.php"; ?>

    <main>
      <!-- Page Info -->
      <section class="content-container">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">HOME</a></li>
            <li class="breadcrumb-item active" aria-current="page">DASHBOARD</li>
          </ol>
        </nav>

        <h1 class="page-title">Hi, <?php echo htmlspecialchars(
            $firstName
        ); ?>!<a href="update-user.php" class="update-button">Update Your Info</a></h1>
       
      </section>

      <!-- Filtering -->
      <section class="filtered-events-container">
        <!-- Filter Section -->
        <aside class="filter-section">
          <h3>Category</h3>
          <div class="categories">
            <button class="filter-button active" data-category="EVENTS">YOUR EVENTS</button>
            <button class="filter-button" data-category="BOOKINGS">YOUR BOOKINGS</button>
          </div>
        </aside>

        <!-- Events Listing Section -->
        <section class="filtered-event-listing">
          <div id="filtered-event-tiles-container" class="filtered-event-tiles"></div>
          <p id="no-result-message" class="no-result-message" style="display: none">
            Sorry, no events match your selection.
          </p>
          <div id="pagination" class="pagination">
            <button id="prevPage" class="arrow left-arrow">
              <img src="img/left-arrow.png" alt="Previous Page" />
            </button>
            <button id="nextPage" class="arrow right-arrow">
              <img src="img/right-arrow.png" alt="Next Page" />
            </button>
          </div>
        </section>
      </section>
    </main>

    <div id="successModal" class="modal">
      <div class="modal-content">
        <span class="close-button">&times;</span>
        <p id="modal-message">Successfully registered for the event!</p>
        <button id="okButton" class="modal-button">OK</button>
      </div>
    </div>

    <?php include "footer.php"; ?>
  </body>
  <script src="scripts/script.js"></script>
  <script src="scripts/member-event-list.js"></script>
</html>
