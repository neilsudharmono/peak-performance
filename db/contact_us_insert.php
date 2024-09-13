<?php
require("db_connection.php");

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capture form data
    $email = $_POST['email'] ?? null;
    $enquiry = $_POST['enquiry'] ?? null;
    $fullname = $_POST['full-name'] ?? null;

    // Validate the data (simple validation)
    if (empty($email) || empty($enquiry)) {
        echo "Please fill in all required fields.";
        exit;
    }

    try {
       
        // Prepare SQL query to insert data
        $sql = "INSERT INTO Contact (Email, Fullname, Enquiry) VALUES (:email,:fullname, :enquiry)";
        $stmt = $pdo->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':enquiry', $enquiry);
        $stmt->bindParam(':fullname', $fullname);


        // Execute the query
        if ($stmt->execute()) {
            echo "Your enquiry has been submitted successfully.";
        } else {
            echo "There was an error submitting your enquiry.";
        }
    } catch (PDOException $e) {
        // If there is an error in the database connection or query, catch it
        echo "Error: " . $e->getMessage();
    }

    // Close the PDO connection
    $pdo = null;
}
?>
