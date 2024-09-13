<?php
require("db/db_connection.php");
session_start();
// Check if user_id is set in the session
if (!isset($_SESSION['user_id'])) {
    // If user_id is not set, redirect to the login page
    header("Location: login.php");
    exit(); // Always call exit after a header redirection
}

// Check if we're in edit mode (i.e., if there's an id in the URL)
$editMode = isset($_GET['id']);
$eventID = $editMode ? $_GET['id'] : null;

// Initialize variables for form fields
$eventName = $eventDate = $startTime = $endTime = $location = $categoryID = $description = $imageURL = '';

// If in edit mode, fetch the existing event details
if ($editMode) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM events WHERE EventID = :eventID");
        $stmt->bindParam(':eventID', $eventID, PDO::PARAM_INT);
        $stmt->execute();
        $event = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($event) {
            // Populate form fields with the existing event data
            $eventName = $event['EventName'];
            $eventDate = $event['EventDate'];
            $startTime = $event['StartTime'];
            $endTime = $event['EndTime'];
            $location = $event['Location'];
            $categoryID = $event['CategoryID'];
            $description = $event['Description'];
            $imageURL = $event['ImageURL'];
        }
    } catch (PDOException $e) {
        echo "Error fetching event details: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Contact us | Peak Performance Sports Club</title>
    <link rel="icon" type="image/x-icon" href="/img/favicon.ico" />
    <link rel="stylesheet" href="css/header.css" />
    <link rel="stylesheet" href="css/footer.css" />
    <link rel="stylesheet" href="css/page-info.css" />
    <link rel="stylesheet" href="css/contact-form.css" />

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

    <main>
      

      <!-- Page Info -->
      <div class="content-container">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">HOME</a></li>
            <li class="breadcrumb-item active" aria-current="page">
              EVENTS
            </li>
          </ol>
        </nav>

        <h1>Booking List</h1>

        <!-- Search Form -->
    <div>
    <input type="text" id="searchInput" placeholder="Search User ID..." />
    </div>
    <br>

              <!-- PHP code to display the event table -->
                <?php include 'db/staff_bookings.php'; ?>
            <br>
           

    </main>

    <?php include 'footer.php'; ?>

  </body>
  <script src="scripts/script.js"></script>
  <script src="scripts/search-booking-staff.js"></script>
</html>

