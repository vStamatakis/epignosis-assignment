<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'cors.php';

// initializing variables
$email  = '';
$pass   = '';
$SignIn = '';

$response = [
  'type' => 'error',
  'message' => 'wrong_data',
  'user_type' => 'undefined'
];

$db = mysqli_connect('localhost', 'root', '', 'db_epignosis');

if (isset($_POST['SignIn'])) {
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $pass  = mysqli_real_escape_string($db, $_POST['pass']);
    
    $stmt   = "SELECT pass FROM users WHERE email = '" . $email . "' ";
    $result = $db->query($stmt);
    $user   = $result->fetch_assoc();
    
    if (password_verify($pass, $user['pass'])) {
        
        $query   = "SELECT * FROM users 
              WHERE email='" . $email . "' AND pass ='" . $user['pass'] . "' ";
        $results = mysqli_query($db, $query);
        $count   = mysqli_num_rows($results);
        
        if ($count == 1) {
            $response['type'] = 'success';
            $response['message'] = 'Loggin in';
            $id_query            = "SELECT id, user_type FROM users WHERE email = '" . $email . "' ";
            $result              = $db->query($id_query);
            $user                = $result->fetch_assoc();
            $_SESSION['id']      = $user['id'];
            $response['type'] = 'success';
            $response['message'] = 'login';
            $response['user_type'] = $user['user_type'];
        } else {
            $response['type'] = 'error';
            $response['message'] = 'Invalid email or password';
        }
    }
    
    else{
        $response['type'] = 'error';
        $response['message'] = 'Invalid email or password';
    }
    
}
echo json_encode($response);
?>