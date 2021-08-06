<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

include 'cors.php';

$user_list = array();

$response["success"] = false;
  
$db = mysqli_connect('localhost', 'root', '', 'db_epignosis');
// $query = "SELECT * FROM users";
// $result = mysqli_query($db, $query);
//iterate over all the rows
$response = array();
$user_id = $_SESSION['id'];
$submissions_query = mysqli_query($db, "SELECT `date_submitted`, `vacation_start`, `vacation_end`, `status`, `days_requested` FROM dates WHERE `user_id` = $user_id ORDER BY `days_requested` DESC") 
                                 or die ("Unable to collect list");
    
while ($row = mysqli_fetch_assoc($submissions_query)){
  $response[] = $row;
} 
echo json_encode($response); 
?>