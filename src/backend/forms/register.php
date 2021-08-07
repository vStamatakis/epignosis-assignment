<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'cors.php';


// initializing variables
$fname       = "";
$lname       = "";
$email       = "";
$pass        = "";
$passConfirm = "";
$create      = "";
$user_type   = "";


$response = [
  'type' => 'error',
  'message' => 'wrong_data'
];

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'db_epignosis');

// REGISTER USER
if (isset($_POST['create'])) {
    
    $fname       = mysqli_real_escape_string($db, $_POST['fname']);
    $lname       = mysqli_real_escape_string($db, $_POST['lname']);
    $email       = mysqli_real_escape_string($db, $_POST['email']);
    $pass        = mysqli_real_escape_string($db, $_POST['pass']);
    $passConfirm = mysqli_real_escape_string($db, $_POST['passConfirm']);
    $user_type   = mysqli_real_escape_string($db, $_POST['user_type']);

    if($fname == '' || $lname == '' || $email == '' || $pass == '' || $passConfirm == '' || $user_type == ''){
        $response['type'] = 'error';
        $response['message'] = 'something is wrong';
        exit;
    }

    
    if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
      exit('Invalid email address');
    }

    $select = mysqli_query($db, "SELECT `email` FROM `users` WHERE `email` = '".$email."'") or exit(mysqli_error($db));
    if(mysqli_num_rows($select)) {
        $response['type'] = 'error';
        $response['message'] = 'This email is already being used';  
        exit('This email is already being used');
    }

    if ($pass == $passConfirm) {
        
        if ($user_type == 'admin') {
            $user_type = 1;
        } else {
            $user_type = 0;
        }
        
        $secure_pass = password_hash($pass, PASSWORD_DEFAULT);
        
        $query = "INSERT INTO users (`fname`, `lname`, `email`, `pass`, `user_type`) 
              VALUES('" . $fname . "', '" . $lname . "', '" . $email . "', '" . $secure_pass . "', '" . $user_type . "')";
        
        $results             = mysqli_query($db, $query);
        $response['type'] = 'success';
        $response['message'] = 'register';        
        
    }
    
}
echo json_encode($response);

?>