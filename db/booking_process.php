<?php
include 'load_facilities.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $facilityID = filter_input(INPUT_POST, 'facility', FILTER_SANITIZE_NUMBER_INT);
    $userID = 1; 
    $fname = filter_input(INPUT_POST, 'first-name');
    $lname = filter_input(INPUT_POST, 'last-name');
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $phone = filter_input(INPUT_POST, 'phone');
    $bookingDate = filter_input(INPUT_POST, 'booking-date');
    $timeFrom = filter_input(INPUT_POST, 'time-from');
    $timeTo = filter_input(INPUT_POST, 'time-to');
    $note = filter_input(INPUT_POST, 'note');

    try {
        
        $stmt = $pdo->prepare("
            INSERT INTO Bookings (FacilityID, UserID, FirstName, LastName, Email, Phone, BookingDate, StartTime, EndTime, Notes)
            VALUES (:facilityID, :userID, :fname, :lname, :email, :phone, :bookingDate, :timeFrom, :timeTo, :note)
        ");

        
        $stmt->bindParam(':facilityID', $facilityID, PDO::PARAM_INT);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        $stmt->bindParam(':fname', $fname, PDO::PARAM_STR);  
        $stmt->bindParam(':lname', $lname, PDO::PARAM_STR);  
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
        $stmt->bindParam(':bookingDate', $bookingDate, PDO::PARAM_STR);  
        $stmt->bindParam(':timeFrom', $timeFrom, PDO::PARAM_STR);  
        $stmt->bindParam(':timeTo', $timeTo, PDO::PARAM_STR);  
        $stmt->bindParam(':note', $note, PDO::PARAM_STR);

        
        $stmt->execute();

        
        header("Location: ../tennis-article.php?bookingSuccess=TRUE");
        exit;

    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
} else {
    echo "Invalid request method.";
}
?>
