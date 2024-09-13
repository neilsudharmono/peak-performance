<?php
require("db_connection.php");



// Check if the EventID is set in the URL
if (isset($_GET['id'])) {
    $bookingID = $_GET['id'];


        try {
            // Prepare the SQL statement to delete the event
            $stmt = $pdo->prepare("DELETE FROM bookings WHERE BookingID = :bookingID");
            $stmt->bindParam(':bookingID', $bookingID, PDO::PARAM_INT);
    
            // Execute the statement
            if ($stmt->execute()) {
                // Redirect to the event listing page with a success message
                header("Location: ../staff-booking-page.php");
                exit();
            } else {
                // If there was a problem, display an error message
                echo "Error: Could not delete the booking.";
            }
        } catch (PDOException $e) {
            // Handle any errors
            echo "Error: " . $e->getMessage();
        }
    
        // Close the connection
        $pdo = null;
    

} else {
    // Redirect if no EventID was provided
    header("Location: staff_events.php?error=No event ID provided");
    exit();
}

function eventHasParticipants($eventID, $pdo) {
    // Query to check if there are participants in EventRegistration table
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM EventRegistrations WHERE EventID = :eventID");
    $stmt->bindParam(':eventID', $eventID, PDO::PARAM_INT);
    $stmt->execute();
    $count = $stmt->fetchColumn();

    return $count > 0; // Returns true if participants exist
}

?>
