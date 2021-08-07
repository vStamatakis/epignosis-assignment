<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include 'cors.php';

$user_list = array();

$response["success"] = false;
  
$db = mysqli_connect('localhost', 'root', '', 'db_epignosis');

$response = array();
$users_query = mysqli_query($db, "SELECT * FROM users") or die ("Unable to collect userlist");
    
while ($row = mysqli_fetch_assoc($users_query)){
  $response[] = $row;
} 
echo json_encode($response); 
?>