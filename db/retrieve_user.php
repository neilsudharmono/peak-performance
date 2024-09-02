<?php
// Include your database connection
require("db_connection.php");
session_start();
// Define UserID
$userID = $_SESSION['user_id'];

// Fetch user details
$sql = "SELECT FirstName, LastName, Email, PhoneNumber FROM Users WHERE UserID = :userId";
$stmt = $pdo->prepare($sql);
$stmt->execute(['userId' => $userID]);
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
