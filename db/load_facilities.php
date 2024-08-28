<?php
require("db_connection.php");

function loadFacilities($pdo, $facilityType) {
    try {
        // Prepare the SQL query to fetch facilities based on the type
        $stmt = $pdo->prepare("SELECT FacilityID, FacilityName FROM Facilities WHERE FacilityType = :facilityType");
        $stmt->bindParam(':facilityType', $facilityType);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
        return [];
    }
}
?>
