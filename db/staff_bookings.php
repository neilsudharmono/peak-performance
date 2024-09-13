<?php
require("db/db_connection.php");


try {
    // Query to fetch event data
    $stmt = $pdo->prepare("SELECT BookingID, FacilityName, BookingDate, TimeDuration, UserID, Notes FROM bookings b
    JOIN Facilities f ON b.FacilityID = f.FacilityID
    JOIN TimeDurations t ON b.TimeDurationID = t.TimeDurationID
    ORDER BY BookingDate ASC");
    $stmt->execute();

    // Check if any rows are returned
    if ($stmt->rowCount() > 0) {
        echo '<table id="eventsTable" border="1" cellspacing="0" cellpadding="10">
                <thead>
                    <tr>
                        <th>Booking ID</th>
                        <th>Facility</th>
                        <th>Booking Date</th>
                        <th>Time</th>
                        <th>User ID</th>
                        <th>Notes</th>
                        <th>Action</th>

                    </tr>
                </thead>
                <tbody>';

        // Fetch each row as an associative array
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo '<tr>
                    <td>' . htmlspecialchars($row["BookingID"]) . '</td>
                    <td>' . htmlspecialchars($row["FacilityName"]) . '</td>
                    <td>' . htmlspecialchars($row["BookingDate"]) . '</td>
                    <td>' . htmlspecialchars($row["TimeDuration"]) . '</td>
                    <td>' . htmlspecialchars($row["UserID"]) . '</td>
                    <td>' . htmlspecialchars($row["Notes"]) . '</td>
                     <td>
                        <a href="db/staff_delete_booking.php?id=' . $row["BookingID"] . '" onclick="return confirm(\'Are you sure you want to delete this booking?\')">Delete</a>
                    </td>

                  </tr>';
        }

        echo '</tbody>
            </table>';
    } else {
        echo 'No events found.';
    }
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}

// Close the connection
$pdo = null;
?>
