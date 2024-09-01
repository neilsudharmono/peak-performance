<?php

require("db_connection.php");

$input = json_decode(file_get_contents('php://input'), true);
try {

if (isset($input['registrationID'])) {
    $registrationID = $input['registrationID'];
    
    $stmt = $pdo->prepare("DELETE FROM EventRegistrations WHERE RegistrationID = :registrationID" );

    $stmt->bindParam(':registrationID', $registrationID,PDO::PARAM_STR); 
    $stmt->execute();

    
    echo json_encode(['success' => true, 'message' => 'Unregistration successful!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid input data.']);
}

} catch(PDOException $e) {
    echo json_encode(['success' => false,'registrationID: ' => $registrationID ,'message' => 'Database error: ' . $e->getMessage()]);
}


?>




