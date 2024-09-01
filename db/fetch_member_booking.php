<?php
require("db_connection.php");
try {
    // Get today's date
    $today = date('Y-m-d');

    // Query to fetch events where BookingDate is greater than or equal to today
    $stmt = $pdo->prepare("
        SELECT 
            b.BookingID as bookingID, 
            b.FacilityID as facilityID, 
            f.FacilityName as facilityName, 
            f.FacilityType as facilityType, 
            b.BookingDate as bookingDate, 
            t.TimeDuration as timeDuration, 
            f.Image as imgSrc, 
            b.Notes as notes 
        FROM 
            Bookings b 
        JOIN 
            Facilities f ON b.FacilityID = f.FacilityID 
        JOIN 
            TimeDurations t ON t.TimeDurationID = b.TimeDurationID 
        WHERE 
            b.UserID = 1 AND b.BookingDate >= :today 
        ORDER BY 
            b.BookingDate, t.TimeDuration ASC
    ");
    
    // Bind the :today parameter to the current date
    $stmt->bindParam(':today', $today);
    
    // Execute the statement
    $stmt->execute();

    // Fetch all events as an associative array
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Output the events as JSON
    echo json_encode($events);

} catch (PDOException $e) {
    echo 'Query failed: ' . $e->getMessage();
}
?>
