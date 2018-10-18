<?php
session_start();

/* Read posted data */
require_once "error_messages.php";  // contains a list of error messages that can be assigned to $_SESSION["error_message"]
require_once 'configuration.php';
require_once 'functions.php';

$email = ltrim(rtrim(filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL)));
if ((empty($email)) || (!filter_var($email, FILTER_VALIDATE_EMAIL))) { 
    $_SESSION["error_message"] = $ERROR_MESSAGE_EMAILS_EMPTY;
    header("location: register_new_user.php"); // deal with invalid input
    exit();
}

$confirmEmail = ltrim(rtrim(filter_input(INPUT_POST, "confirmEmail", FILTER_SANITIZE_EMAIL)));
if ((empty($confirmEmail)) || (!filter_var($confirmEmail, FILTER_VALIDATE_EMAIL))) { 
    $_SESSION["error_message"] = $ERROR_MESSAGE_EMAILS_EMPTY;
    header("location: register_new_user.php"); // deal with invalid input
    exit();
}


/* Validate input data */
if ($email != $confirmEmail) {
    $_SESSION["error_message"] = $ERROR_MESSAGE_EMAILS_DO_NOT_MATCH;
    header("location: register_new_user.php");
    exit();
}


/* Connect to the database */
require_once "configuration.php";



/* Connect to the database */
$dbConnection = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUsername, $dbPassword);
$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   // set the PDO error mode to exception

/* Create new pending user */
$expiry_time_stamp = 1200 + $_SERVER["REQUEST_TIME"]; // 1200 = 20 minutes from now
$token = sha1(uniqid($email, true));

newPendingUser($dbConnection, $token, $email, $expiry_time_stamp);
$_SESSION["email"] = $email;


$response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6Le5lVMUAAAAANvtDq47EalOCXfQgQVr87Yqnrei&response=".$_POST['g-recaptcha-response']."&remoteip=".$_SERVER['REMOTE_ADDR']);
$obj = json_decode($response);
if($obj->success == true)
{
    
    $newURL = $siteName . '/confirm_registration.php?token=' . $token;
          header('Location: ' . $newURL);
}
else
{
   $_SESSION["error_message"] = $ERROR_MESSAGE_CAPTCHA_FAILED;
   $newURL = 'register_new_user.php';
          header('Location: ' . $newURL);
}
 

?>
