<?php
// Include your database connection
require("db_connection.php");

// Define UserID
$userId = 1;

// Fetch user details
$sql = "SELECT FirstName, LastName, Email, PhoneNumber FROM Users WHERE UserID = :userId";
$stmt = $pdo->prepare($sql);
$stmt->execute(['userId' => $userId]);
$user = $stmt->fetch();

// Check if user data is found
if ($user) {
    $firstName = $user['FirstName'];
    $lastName = $user['LastName'];
    $email = $user['Email'];
    $phone = $user['PhoneNumber'];
} else {
    // Default values if user not found
    $firstName = $lastName = $email = $phone = '';
}
?>
