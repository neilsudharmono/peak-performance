<?php
require("db/db_connection.php");
session_start();

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

        <h1>Event List</h1>

        <!-- Search Form -->
    <div>
    <input type="text" id="searchInput" placeholder="Search events name..." />
    </div>
    <br>

              <!-- PHP code to display the event table -->
                <?php include 'db/staff_events.php'; ?>
            <br>
            <?php include 'db/staff_edit_or_create_event.php'; ?>

            
            <h1  id="eventForm"><?php echo $editMode ? 'Edit Event' : 'Create New Event'; ?></h1>
            </div>


     

      <section class="contact-form">
    <form id="event-form" action="<?php echo $editMode ? 'db/staff_edit_event.php' : 'db/staff_create_event.php'; ?>" method="post" enctype="multipart/form-data" novalidate>
        <?php if ($editMode): ?>
            <input type="hidden" name="event_id" value="<?php echo $eventID; ?>">
        <?php endif; ?>

        <div class="form-group">
            <label for="event-name">Event Name:</label>
            <input type="text" id="event-name" name="event_name"  <?php if ($editMode):?> value="<?php echo htmlspecialchars($eventName); ?> "  <?php endif; ?> required>
            <span id="event-name-error" class="error-message"></span>
        </div>

        <div class="form-group">
            <label for="event-date">Event Date:</label>
            <input type="date" id="event-date" name="event_date"  <?php if ($editMode):?> value="<?php echo htmlspecialchars($eventDate); ?> "  <?php endif; ?>  required>
            <span id="event-date-error" class="error-message"></span>
        </div>

        <div class="form-group">
            <label for="start-time">Start Time:</label>
            <input type="time" id="start-time" name="start_time" <?php if ($editMode):?> value="<?php echo htmlspecialchars($startTime); ?> "  <?php endif; ?>  required>
                <span id="start-time-error" class="error-message"></span>

            
        </div>

        <div class="form-group">
            <label for="end-time">End Time:</label>
            <input type="time" id="end-time" name="end_time" <?php if ($editMode):?> value="<?php echo htmlspecialchars($endTime); ?> "  <?php endif; ?> required>
            <span id="end-time-error" class="error-message"></span>
            

        </div>

        <div class="form-group">
            <label for="location">Location:</label>
            <input type="text" id="location" name="location" <?php if ($editMode):?> value="<?php echo htmlspecialchars(string: $location); ?> "  <?php endif; ?> required>
            <span id="location-error" class="error-message"></span>
            
        </div>

                <div class="form-group">
            <label for="category">Category:</label>
            <select id="category" name="category_id" required>
                <option value="1" <?php if ($editMode):?> <?php if ($categoryID == '1') echo 'selected'; ?> <?php else: ?> selected <?php endif; ?>>Tennis</option>
                <option value="2" <?php if ($editMode && $categoryID == '2') echo 'selected'; ?>>Lawn Bowling</option>
                <option value="3" <?php if ($editMode && $categoryID == '3') echo 'selected'; ?>>Function</option>
            </select>
            <span id="category-error" class="error-message"></span>
        </div>

        <div class="form-group">
            <label for="description">Description:</label>
            <textarea id="description" name="description" required><?php echo htmlspecialchars($description); ?></textarea>
            <span id="description-error" class="error-message"></span>
            

        </div>

        <div class="form-group">
            <label for="image">Event Image:</label>
            <input type="file" id="event-image" name="image" accept="image/*">
            <?php if ($imageURL): ?>
                <p>Current Image: <img src="<?php echo htmlspecialchars($imageURL); ?>" alt="Event Image" style="width: 100px;"></p>
            <?php endif; ?>
            <span id="event-image-error" class="error-message"></span>

        </div>
        <div class="form-buttons">

        <button type="submit"><?php echo $editMode ? 'Edit Event' : 'Create Event'; ?></button>
        <?php if ($editMode): ?>
            <a href="staff-events-page.php" class="cancel-btn">Cancel</a>
        <?php endif; ?>
        </div>
    </form>
    </section>

    </main>

    <?php include 'footer.php'; ?>

  </body>
  <script src="scripts/script.js"></script>
  <script src="scripts/search-event-staff.js"></script>
  <script src="scripts/staff-event.js"></script>

</html>

