<?php
require("db_connection.php");
session_start();
$input = json_decode(file_get_contents('php://input'), true);
try {

    // Check if eventID and userID are set
if (isset($input['eventID']) && isset($_SESSION["user_id"])) {
    $eventID = $input['eventID'];
    $userID = $_SESSION["user_id"];

    $stmt = $pdo->prepare("INSERT INTO EventRegistrations (EventID, UserID, RegistrationDate) VALUES (:eventID, :userID, NOW())" );
    $stmt->bindParam(':eventID', $eventID,PDO::PARAM_INT); 
    $stmt->bindParam(':userID', $userID,PDO::PARAM_INT);
    $stmt->execute();

    
    echo json_encode(['success' => true, 'message' => 'Registration successful!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid input data.']);
}

    

   

} catch(PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}


?>
