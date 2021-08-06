<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'cors.php';

$user_list = array();
$id = '';

$response["success"] = false;
  
$db = mysqli_connect('localhost', 'root', '', 'db_epignosis');

$id = mysqli_real_escape_string($db, $_POST['id']);
// $query = "SELECT * FROM users";
// $result = mysqli_query($db, $query);
//iterate over all the rows
$response = '';
$users_query = mysqli_query($db, "SELECT fname, lname, email, user_type FROM users WHERE id = $id") or die ("Unable to collect userlist");
    
while ($row = mysqli_fetch_assoc($users_query)){
  $response = $row;
}
echo json_encode($response); 
?>