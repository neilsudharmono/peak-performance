<?php
session_start();
$response = array('isLoggedIn' => false);

if (isset($_SESSION['user_id'])) {
  $response['isLoggedIn'] = true;
}

echo json_encode($response);
?>