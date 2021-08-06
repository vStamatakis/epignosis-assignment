<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set("mail.log", "/tmp/mail.log");
ini_set("mail.add_x_header", TRUE);
error_reporting(E_ALL);
include 'cors.php';

// initializing variables
$from          = '';
$until         = '';
$reason        = '';
$submit        = '';
$dateSubmitted = '';

$response["success"] = false;

$db = mysqli_connect('localhost', 'root', '', 'db_epignosis');

if (isset($_POST['submit'])) {
    //   $user_id = mysqli_real_escape_string($db, $_POST['user_id']);
    $from          = mysqli_real_escape_string($db, $_POST['from']);
    $until         = mysqli_real_escape_string($db, $_POST['until']);
    $reason        = mysqli_real_escape_string($db, $_POST['reason']);
    $dateSubmitted = mysqli_real_escape_string($db, $_POST['dateSubmitted']);
    
    $vacation_start = $from;
    $vacation_end   = $until;
    $user_id        = $_SESSION['id'];
    
    $status = 'pending';
    
    function dateDiff($from, $until)
    {
        $date1_ts = strtotime($from);
        $date2_ts = strtotime($until);
        $diff     = $date2_ts - $date1_ts;
        return round($diff / 86400);
    }
    
    $days_requested = dateDiff($from, $until);
    
    $stmt = "INSERT INTO dates (`user_id`, `vacation_start`, `vacation_end`, `reason`, `date_submitted`, `status`, `days_requested`) 
        VALUES('" . $user_id . "', '" . $vacation_start . "', '" . $vacation_end . "', '" . $reason . "', '" . $dateSubmitted . "' , '" . $status . "', '" . $days_requested . "')";
    
    $results = mysqli_query($db, $stmt);
    $response["success"] = true;
    
    $id_query = "SELECT email, fname, lname FROM users WHERE id = '" . $user_id . "' ";
    $result = $db->query($id_query);
    $user = $result->fetch_assoc();
    
    $admins_query = "SELECT email FROM users WHERE user_type = 1";
    $results      = $db->query($admins_query);
    $users        = $results->fetch_assoc();
    $email        = $users['email'];

    $applicant_email = $user['email'];

    $to = $email; 
    
    // subject
    $subject = 'Vacation request';
    
    // message
    $message = '
            <html>
            <head>
            <title>Vacation Request</title>
            </head>
            <body>
            <p>Here is the Request from "' . $user['fname'] . '"</p>
            <table>
                <tr>
                <p>“D​ear supervisor, employee "' . $user['fname'] . '" "' . $user['lname'] . '" requested for some time off, starting on "' . $vacation_start . '" and ending on "' . $vacation_end . '", stating the reason: "' . $reason . '"</p>
                </tr>
                <tr>
                <p>Click on one of the below links to approve or reject the application:”​</p>
                <a href="http://localhost/forms/approve_submission.php">Approve</a><br>
                <a href="http://localhost/forms/reject_submission.php">Reject</a>
                </tr>
            </table>
            </body>
            </html>
            ';
    

    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    
    $headers = array(
        "From: $applicant_email",
        "Reply-To: $applicant_email", 
        "X-Mailer: PHP/" . PHP_VERSION
    );
    $headers = implode("\r\n", $headers);
    
    
    mail($to, $subject, $message, $headers);
}

echo json_encode($response);
?>