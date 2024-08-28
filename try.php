<?php
require("db/db_connection.php");
try {
    // Fetch only Tennis facilities from the database
    $stmt = $pdo->prepare("SELECT FacilityID, FacilityName FROM Facilities WHERE FacilityType = 'Tennis'");
    $stmt->execute();
    $facilities = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
?>