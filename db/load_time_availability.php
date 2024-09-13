<?php
// Enable error reporting

require("db_connection.php");

if (isset($_POST['facilityId']) && isset($_POST['bookingDate'])) {
    $facilityId = $_POST['facilityId'];
    $bookingDate = $_POST['bookingDate'];

    // Query to find available time durations
    $sql = "SELECT td.TimeDurationID, td.TimeDuration 
            FROM TimeDurations td
            WHERE td.TimeDurationID NOT IN (
                SELECT b.TimeDurationID
                FROM bookings b
                WHERE b.FacilityID = :facilityId AND b.BookingDate = :bookingDate
            )";

    $stmt = $pdo->prepare($sql);
    $stmt->execute(['facilityId' => $facilityId, 'bookingDate' => $bookingDate]);
    $timeSlots = $stmt->fetchAll();

    if ($timeSlots) {
        foreach ($timeSlots as $slot) {
            echo '<option value="'.$slot['TimeDurationID'].'">'.$slot['TimeDuration'].'</option>';
        }
    } else {
        echo '<option value="">No available time slots</option>';
    }
}
?>
