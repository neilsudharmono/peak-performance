<?php

header('Content-Type: application/json');
session_start();
require('db_connection.php');

$input = json_decode(file_get_contents('php://input'), true);

if (isset($input['eventID']) && isset($_SESSION["user_id"])) {
    $eventID = $input['eventID'];
    $userID = $_SESSION["user_id"];

    // Query to check if the user is already registered
    $query = "SELECT COUNT(*) as count FROM EventRegistrations WHERE EventID = ? AND UserID = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$eventID, $userID]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result['count'] > 0) {
        echo json_encode(['success' => true, 'isRegistered' => true]);
    } else {
        echo json_encode(['success' => true, 'isRegistered' => false]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid input data.']);
}
?>