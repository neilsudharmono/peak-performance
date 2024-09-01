<?php

header('Content-Type: application/json');

require('db_connection.php');

$input = json_decode(file_get_contents('php://input'), true);

if (isset($input['eventID']) && isset($input['userID'])) {
    $eventID = $input['eventID'];
    $userID = $input['userID'];

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