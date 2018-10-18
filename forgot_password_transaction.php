<?php
session_start();
?>


<?php
/* Read posted data */
require_once "error_messages.php";  // contains a list of error messages that can be assigned to $_SESSION["error_message"]

$email = ltrim(rtrim(filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL)));
if ((empty($email)) || (!filter_var($email, FILTER_VALIDATE_EMAIL)))
{
    $_SESSION["error_message"] = $ERROR_MESSAGE_INVALID_OR_EMPTY_FIELD;
    header("location: forgot_password.php"); // deal with invalid input
    exit();
}


$confirmEmail = ltrim(rtrim(filter_input(INPUT_POST, "confirmEmail", FILTER_SANITIZE_EMAIL)));
if ((empty($confirmEmail)) || (!filter_var($confirmEmail, FILTER_VALIDATE_EMAIL)))
{
    $_SESSION["error_message"] = $ERROR_MESSAGE_INVALID_OR_EMPTY_FIELD;
    header("location: forgot_password.php"); // deal with invalid input
    exit();
}


if ($email != $confirmEmail)
{
    $_SESSION["error_message"] = $ERROR_MESSAGE_EMAILS_DO_NOT_MATCH;
    header("location: forgot_password.php"); // deal with invalid input
    exit();
}

/* Connect to the database */
require_once "configuration.php";



/* Connect to the database */
$dbConnection = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUsername, $dbPassword);
$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   // set the PDO error mode to exception



/* Check that user is already added  */
$query = "SELECT email FROM users WHERE email = :email";
$statement = $dbConnection->prepare($query);
$statement->bindParam(":email", $email, PDO::PARAM_STR);
$statement->execute();


if ($statement->rowCount() == 0)
{
    $_SESSION["error_message"] = $ERROR_MESSAGE_INVALID_OR_EMPTY_FIELD;
    header("location: forgot_password.php"); // deal with invalid input
    exit();
}


/* If the user is already in the pending_user table, then remove the old entry */
$query = "DELETE FROM pending_users WHERE email = :email";
$statement = $dbConnection->prepare($query);
$statement->bindParam(":email", $email, PDO::PARAM_STR);
$statement->execute();


/* Create new entry in the pending_user table for this email */
$expiry_time_stamp = 1200 + $_SERVER["REQUEST_TIME"]; // 1200 = 20 minutes from now
$token = sha1(uniqid($email, true));

$query = "INSERT INTO pending_users (token, email, expiry_time_stamp) VALUES (:token, :email, :expiry_time_stamp)";
$statement = $dbConnection->prepare($query);
$statement->bindParam(":token", $token, PDO::PARAM_STR);
$statement->bindParam(":email", $email, PDO::PARAM_STR);
$statement->bindParam(":expiry_time_stamp", $expiry_time_stamp, PDO::PARAM_INT);
$statement->execute();


/* remove all old pending users from database */
$query = "DELETE FROM pending_users WHERE expiry_time_stamp < :expiry_time_stamp";
$statement = $dbConnection->prepare($query);
$statement->bindParam(":expiry_time_stamp", $_SERVER["REQUEST_TIME"], PDO::PARAM_INT);
$statement->execute();
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login Example</title>
<link href="login_and_registration.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<div id="dkit_container">

<?php
include_once 'header.php';
set_header("DkIT", "Password Reset", false);
?>
<main>

<?php
/* Provide feedback and provide a way for the user to proceed or automatically redirect to a new webpage */
echo "In a real website, an email would now be sent to the user with the link below.<br>";
echo "In this example, you can click on the link below to emulate the effect of following the link in the email.<br><br>";

echo "<a href = '" . $siteName . "/forgot_password_confirm_new_password.php?token=" . $token . "'>" . $siteName . "/forgot_password_confirm_new_password.php?token=" . $token . "</a>";
echo "<br><br><br>";

echo "<h3 style='color:red'>Below is an axample content that can be used if sending a forgot password email to the user</h3>";



echo "An email has been sent to you to allow you to change your password.<br><br>" .
 "If you do not receive an email, please check your junk folder for an email from us. Our email is:<br>" .
 "<strong>D00123456@student.dkit.ie</strong><br><br>" .
 "If you still cannot find our email, please add our email address to your email whitelist and attempt to recover your email again.<br><br>";

$subject = "DkIT Login Example Password Reset";
$comment = "You are receiving this email because you requested a new password from DkIT Login Example." .
        " If you did not request a new password from us, then simply ignore this email.<br><br>" .
        "Click on the link below to reset your password:<br>" .
        "<a href = '" . $siteName . "/forgot_password_confirm_new_password.php?token=" . $token . "'>" . $siteName . "/forgot_password_confirm_new_password.php?token=" . $token . "</a><br><br>" .
        "If the link above does not work, then cut-and-paste it into your browser address bar and run it from there.<br><br>" .
        "<br><br>Yours in Sport<br>DkIT Login Example Registration Team";

$headers = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
mail($email, $subject, $comment, $headers);
?>        

<br><br><input type="button" value = "Go back to login webpage" onclick="window.open('login.php', '_self')">


</main>

<?php
include_once 'footer.php';
?>
</div> <!-- dkit_container -->
</body>
</html>