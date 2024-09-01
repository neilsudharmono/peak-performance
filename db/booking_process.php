<?php
include 'load_facilities.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $facilityID = filter_input(INPUT_POST, 'facility', FILTER_SANITIZE_NUMBER_INT);
    $userID = 1; 
    $bookingDate = filter_input(INPUT_POST, 'booking-date');
    $timeDur = filter_input(INPUT_POST, 'time-duration', FILTER_SANITIZE_NUMBER_INT);
    $note = filter_input(INPUT_POST, 'note');



    try {
        


            $stmt = $pdo->prepare("
            INSERT INTO bookings (FacilityID, UserID, BookingDate, TimeDurationID, Notes)
            VALUES (:facilityID, :userID, :bookingDate, :timeDur, :note)
        ");

        
        $stmt->bindParam(':facilityID', $facilityID, PDO::PARAM_INT);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        $stmt->bindParam(':bookingDate', $bookingDate, PDO::PARAM_STR);   
        $stmt->bindParam(':timeDur', $timeDur, PDO::PARAM_INT);  
        $stmt->bindParam(':note', $note, PDO::PARAM_STR);
        $stmt->execute();

        if (isset($_SERVER['HTTP_REFERER'])) {
            $referrer = $_SERVER['HTTP_REFERER'];
            
            // Parse the URL to check if 'bookingSuccess' is already present
            $parsed_url = parse_url($referrer);
            parse_str($parsed_url['query'] ?? '', $query_params);
        
            // Add 'bookingSuccess=TRUE' only if it's not already present
            if (!isset($query_params['bookingSuccess'])) {
                $referrer .= (strpos($referrer, '?') === false ? '?' : '&') . "bookingSuccess=TRUE";
            }

            header("Location: " . $referrer);
            exit();
        }   
        



    } catch (PDOException $e) {
        echo"". $e->getMessage();
    }
} else {
    echo "Invalid request method.";
}
?>
