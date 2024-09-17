<?php
require("db_connection.php");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $eventName = $_POST['event_name'];
    $eventDate = $_POST['event_date'];
    $startTime = $_POST['start_time'];
    $endTime = $_POST['end_time'];
    $location = $_POST['location'];
    $categoryID = $_POST['category_id'];
    $description = $_POST['description'];
    $eventStatus = 'Scheduled';  // Default status for new events

    // Handle image upload
    $targetDir = "../img/";
    $imageFile = basename($_FILES["image"]["name"]);
    $targetFilePath = $targetDir . $imageFile;
    $targetFileInsert = "img/".$imageFile;
    $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

    // Check if image file is a real image or a fake one
    if (isset($_FILES["image"])) {
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check === false) {
            echo "File is not an image.";
            exit();
        }
    }

    // Move the uploaded file to the target directory
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
        //echo "The file ". htmlspecialchars($imageFile) . " has been uploaded.";
    } else {
        echo "Error uploading image.";
        exit();
    }

    try {
        // Insert event data into the database
        $stmt = $pdo->prepare("INSERT INTO Events (EventName, EventDate, StartTime, EndTime, Location, CategoryID, Description, EventStatus, ImageURL) 
                               VALUES (:eventName, :eventDate, :startTime, :endTime, :location, :categoryID, :description, :eventStatus, :imageURL)");
        
        // Bind parameters
        $stmt->bindParam(':eventName', $eventName);
        $stmt->bindParam(':eventDate', $eventDate);
        $stmt->bindParam(':startTime', $startTime);
        $stmt->bindParam(':endTime', $endTime);
        $stmt->bindParam(':location', $location);
        $stmt->bindParam(':categoryID', $categoryID, PDO::PARAM_INT);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':eventStatus', $eventStatus);
        $stmt->bindParam(':imageURL', $targetFileInsert);

        // Execute the statement
        if ($stmt->execute()) {
            // Redirect back to events list with a success message
            header("Location: ../staff-events-page.php");
            exit();
        } else {
            echo "Error: Could not create the event.";
        }
    } catch (PDOException $e) {
        // Handle any errors
        echo "Error: " . $e->getMessage();
    }

    // Close the connection
    $pdo = null;
}
?>
