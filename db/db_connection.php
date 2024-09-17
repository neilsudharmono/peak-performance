<?php
$servername = 'sql305.byetcluster.com';  
$dbname = 'if0_37303582_peakperformance';  
$username = 'if0_37303582';  
$password = 'nJs0p7Jfvt2'; 


try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}

/*
$servername = 'localhost';  
$dbname = 'peakperformance';  
$username = 'root';  
$password = 'root'; 
$port = 8888;

try {
    $pdo = new PDO("mysql:host=$servername;port=$port;dbname=$dbname;charset=utf8", $username, $password);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}

*/

?>
