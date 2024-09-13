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

    // Check if the event has participants
    if (eventHasParticipants($eventID, $pdo)) {
        echo "<script>alert('This event cannot be edited because participants are registered.');</script>";
        echo "<script>window.location.href = '../staff-events-page.php';</script>";
        exit();
    } else {
        // Handle image upload if a new file was uploaded
        if (isset($_FILES['image']) && $_FILES['image']['name']) {
            $targetDir = "../img/";
            $imageFile = basename($_FILES["image"]["name"]);
            $targetFilePath = $targetDir . $imageFile;
            $targetFileInsert = "img/" . $imageFile;
            $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

            // Validate the uploaded image
            if (getimagesize($_FILES["image"]["tmp_name"]) !== false) {
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
                    // New image uploaded, use the new one
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
            // Use the existing image if no new image was uploaded
            $imageURL = $_POST['current_image'];
        }

        // Update the event in the database
        try {
            $stmt = $pdo->prepare("UPDATE events 
                SET EventName = :eventName, EventDate = :eventDate, StartTime = :startTime, EndTime = :endTime, 
                    Location = :location, CategoryID = :categoryID, Description = :description, ImageURL = :imageURL 
                WHERE EventID = :eventID");

            // Bind parameters
            $stmt->bindParam(':eventName', $eventName);
            $stmt->bindParam(':eventDate', $eventDate);
            $stmt->bindParam(':startTime', $startTime);
            $stmt->bindParam(':endTime', $endTime);
            $stmt->bindParam(':location', $location);
            $stmt->bindParam(':categoryID', $categoryID, PDO::PARAM_INT);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':imageURL', $imageURL);
            $stmt->bindParam(':eventID', $eventID, PDO::PARAM_INT);

            // Execute the query
            if ($stmt->execute()) {
                // Redirect on success
                header("Location: ../staff-events-page.php?status=success");
                exit();
            } else {
                echo "Error: Could not update the event.";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

        // Close the connection
        $pdo = null;
    }
}

// Function to check if event has participants
function eventHasParticipants($eventID, $pdo) {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM EventRegistrations WHERE EventID = :eventID");
    $stmt->bindParam(':eventID', $eventID, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchColumn() > 0;
}
?>
