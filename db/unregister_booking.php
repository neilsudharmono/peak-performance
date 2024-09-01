<?php

require("db_connection.php");

$input = json_decode(file_get_contents('php://input'), true);
try {

if (isset($input['bookingID'])) {
    $bookingID = $input['bookingID'];
    
    $stmt = $pdo->prepare("DELETE FROM bookings WHERE BookingID = :bookingID" );

    $stmt->bindParam(':bookingID', $bookingID,PDO::PARAM_STR); 
    $stmt->execute();

    
    echo json_encode(['success' => true, 'message' => 'Unregistration successful!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid input data.']);
}

} catch(PDOException $e) {
    echo json_encode(['success' => false,'registrationID: ' => $bookingID ,'message' => 'Database error: ' . $e->getMessage()]);
}


?>




