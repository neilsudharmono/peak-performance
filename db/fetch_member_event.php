<?php
require("db_connection.php");
session_start();
try {
    $userID = $_SESSION['user_id'];
    // Query to fetch events
    $stmt = $pdo->prepare("SELECT er.RegistrationID as registrationID, e.EventID as eventID, e.EventName as title, e.EventDate as date, e.Description as description, 
                                  ec.CategoryName as category, e.ImageURL as imgSrc
                           FROM Events e
                           JOIN EventCategories ec ON e.CategoryID = ec.CategoryID
                           JOIN EventRegistrations er ON e.EventID = er.EventID
                           WHERE e.EventStatus = 'Scheduled' AND
                           er.userID = $userID
                           ORDER BY e.EventDate ASC");
    $stmt->execute();

    // Fetch all events as an associative array
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Output the events as JSON
    echo json_encode($events);

} catch (PDOException $e) {
    echo 'Query failed: ' . $e->getMessage();
}
?>
