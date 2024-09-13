<?php
require("db/db_connection.php");


try {
    // Query to fetch event data
    $stmt = $pdo->prepare("SELECT EventID, EventName , EventDate, StartTime, EndTime, Location, CategoryName, Description, EventStatus, ImageURL 
    FROM events e JOIN  EventCategories c  On e.CategoryID = c.CategoryID ORDER BY EventDate ASC");
    $stmt->execute();

    // Check if any rows are returned
    if ($stmt->rowCount() > 0) {
        echo '<table id="eventsTable" border="1" cellspacing="0" cellpadding="10">
                <thead>
                    <tr>
                        <th>Event Name</th>
                        <th>Date</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Location</th>
                        <th>Category</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>URL</th>
                        <th>Actions</th> 

                    </tr>
                </thead>
                <tbody>';

        // Fetch each row as an associative array
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo '<tr>
                    <td>' . htmlspecialchars($row["EventName"]) . '</td>
                    <td>' . htmlspecialchars($row["EventDate"]) . '</td>
                    <td>' . htmlspecialchars($row["StartTime"]) . '</td>
                    <td>' . htmlspecialchars($row["EndTime"]) . '</td>
                    <td>' . htmlspecialchars($row["Location"]) . '</td>
                    <td>' . htmlspecialchars($row["CategoryName"]) . '</td>
                    <td>' . htmlspecialchars($row["Description"]) . '</td>
                    <td>' . htmlspecialchars(string: $row["EventStatus"]) . '</td>
                    <td>' . htmlspecialchars(string: $row["ImageURL"]) . '</td>
                     <td>
                        <a href="staff-events-page.php?id=' . $row["EventID"] . '#eventForm">Edit</a> |
                        <a href="db/staff_delete_event.php?id=' . $row["EventID"] . '" onclick="return confirm(\'Are you sure you want to delete this event?\')">Delete</a>
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
