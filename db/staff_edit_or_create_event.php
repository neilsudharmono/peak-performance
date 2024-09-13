<?php
require("db_connection.php");

// Check if we're in edit mode (i.e., if there's an id in the URL)
$editMode = isset($_GET['id']);
$eventID = $editMode ? $_GET['id'] : null;

// Initialize variables for form fields
$eventName = $eventDate = $startTime = $endTime = $location = $categoryID = $description = $imageURL = '';

// If in edit mode, fetch the existing event details
if ($editMode) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM Events WHERE EventID = :eventID");
        $stmt->bindParam(':eventID', $eventID, PDO::PARAM_INT);
        $stmt->execute();
        $event = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($event) {

 
            // Populate form fields with the existing event data
            $eventName = $event['EventName'];
            $eventDate = DateTime::createFromFormat('Y-m-d', $event['EventDate'])->format('Y-m-d');
            $startTime = DateTime::createFromFormat('H:i:s', $event['StartTime'])->format('h:i:s');
            $endTime = DateTime::createFromFormat('H:i:s', $event['EndTime'])->format('h:i:s');
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