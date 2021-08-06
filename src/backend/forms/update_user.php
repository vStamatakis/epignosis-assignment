<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'cors.php';

// initializing variables
$id        = "";
$fname     = "";
$lname     = "";
$email     = "";
$user_type = "";
$create    = "";

$response = [
    'type' => 'error',
    'message' => 'wrong_data'
  ];

$db = mysqli_connect('localhost', 'root', '', 'db_epignosis');

if (isset($_POST['Update'])) {
    $id        = mysqli_real_escape_string($db, $_POST['id']);
    $fname     = mysqli_real_escape_string($db, $_POST['fname']);
    $lname     = mysqli_real_escape_string($db, $_POST['lname']);
    $email     = mysqli_real_escape_string($db, $_POST['email']);
    $user_type = mysqli_real_escape_string($db, $_POST['user_type']);
    
    if ($user_type == 'admin') {
        $user_type = 1;
    } else {
        $user_type = 0;
    }
    
    $sql                 = "UPDATE users SET fname = '" . $fname . "', lname = '" . $lname . "', email = '" . $email . "', user_type = '" . $user_type . "' WHERE id = '" . $id . "'";
    $users_query         = mysqli_query($db, $sql);
    $response['type'] = 'success';
    $response['message'] = 'User updated';
    
}
echo json_encode($response);
?>