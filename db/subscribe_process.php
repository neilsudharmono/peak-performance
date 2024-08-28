<?php
include 'db_connection.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $currentDate = date('Y-m-d');

    try {
        $stmt = $pdo->prepare("
            INSERT INTO Subscribers (Email, SubscriptionDate, StatusID)
            VALUES (:email, :subscriptionDate, 1)
        ");

        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':subscriptionDate', $currentDate, PDO::PARAM_STR);
        $stmt->execute();

        // Redirect to index.php with anchor for success message
        header("Location: ../index.php?subscribeSuccess=TRUE#success-message");
        exit;

    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
} else {
    echo "Invalid request method.";
}
?>
