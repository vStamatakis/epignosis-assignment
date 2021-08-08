<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set("mail.log", "/tmp/mail.log");
ini_set("mail.add_x_header", TRUE);
error_reporting(E_ALL);
include 'cors.php';


$db = mysqli_connect('localhost', 'root', '', 'db_epignosis');
$id = $_SESSION['id'];
$request_query = "SELECT email FROM users WHERE id = $id ";
$results = $db->query($request_query);
$users = $results->fetch_assoc(); 
$email = $users['email'];

$date_submitted_query = "SELECT date_submitted FROM dates WHERE `user_id` = $id ";
$result = $db->query($date_submitted_query);
$user = $result->fetch_assoc(); 
$date_submitted = $user['date_submitted'];

$status = 'approved';
$sql = "UPDATE dates SET `status` = '".$status."' WHERE `user_id` = $id AND `date_submitted` = $date_submitted ";
mysqli_query($db, $sql);

$_SESSION['admin-mail'] = $from; 
$to = $email;


$subject = 'Vacation request accepted';


$message = '
<html>
<head>
  <title>Vacation request accepted</title>
</head>
<body>
      <p>“D​ear employee, your supervisor has accepted
       your application submitted on "'.$date_submitted.'".”​</p>
</body>
</html>
';

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

$headers .= 'From: '.$from.' ' . "\r\n" .
    'Reply-To: '.$from.' ' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();


mail($to, $subject, $message, $headers);

?>