<?php
require("db_connection.php");



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $eventID = $_POST['event_id'];
    $eventName = $_POST['event_name'];
    $eventDate = $_POST['event_date'];
    $startTime = $_POST['start_time'];
    $endTime = $_POST['end_time'];
    $location = $_POST['location'];
    $categoryID = $_POST['category_id'];
    $description = $_POST['description'];

    if (eventHasParticipants($eventID, $pdo)) {
        // Show an error message if there are participants
        echo "<script>alert('This event cannot be edited because participants are registered.');</script>";
        echo "<script>window.location.href = '../staff-events-page.php';</script>";
        exit();
    }
    else {
         // Handle image upload if a new file was uploaded
    if ($_FILES['image']['name']) {
        $targetDir = "../img/";
        $imageFile = basename($_FILES["image"]["name"]);
        $targetFilePath = $targetDir . $imageFile;
        $targetFileInsert = "img/".$imageFile;
        $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

        // Validate the uploaded image
        if (getimagesize($_FILES["image"]["tmp_name"]) !== false) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
                $imageURL = $targetFileInsert;
            } else {
                echo "Error uploading image.";
                exit();
            }
        } else {
            echo "Invalid image file.";
            exit();
        }
    } else {
        // Use existing image if no new image is uploaded
        $imageURL = $_POST['existing_image'];
    }

    try {
        // Update event data in the database
        $stmt = $pdo->prepare("UPDATE events SET EventName = :eventName, EventDate = :eventDate, StartTime = :startTime, EndTime = :endTime, Location = :location, CategoryID = :categoryID, Description = :description, ImageURL = :imageURL WHERE EventID = :eventID");
        $stmt->bindParam(':eventName', $eventName);
        $stmt->bindParam(':eventDate', $eventDate);
        $stmt->bindParam(':startTime', $startTime);
        $stmt->bindParam(':endTime', $endTime);
        $stmt->bindParam(':location', $location);
        $stmt->bindParam(':categoryID', $categoryID, PDO::PARAM_INT);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':imageURL', $imageURL);
        $stmt->bindParam(':eventID', $eventID, PDO::PARAM_INT);

        if ($stmt->execute()) {
            // Redirect with success message
            header("Location: ../staff-events-page.php");
            exit();
        } else {
            echo "Error: Could not update the event.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    $pdo = null;

    }

   
}

function eventHasParticipants($eventID, $pdo) {
    // Query to check if there are participants in EventRegistration table
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM EventRegistrations WHERE EventID = :eventID");
    $stmt->bindParam(':eventID', $eventID, PDO::PARAM_INT);
    $stmt->execute();
    $count = $stmt->fetchColumn();

    return $count > 0; // Returns true if participants exist
}
?>

