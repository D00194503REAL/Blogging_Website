<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login Example</title>
</head>
<body>

<?php
/* Read posted data */
require_once "error_messages.php";  // contains a list of error messages that can be assigned to $_SESSION["error_message"]

$token = ltrim(rtrim(filter_input(INPUT_POST, "token", FILTER_SANITIZE_STRING)));
if (empty($token))
{
    $_SESSION["error_message"] = $ERROR_MESSAGE_INVALID_OR_EMPTY_FIELD;
    header("location: forgot_password_confirm_new_password.php?token=" . $token); // deal with invalid input
    exit();
}

$email = ltrim(rtrim(filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL)));
if ((empty($email)) || (!filter_var($email, FILTER_VALIDATE_EMAIL)))
{
    $_SESSION["error_message"] = $ERROR_MESSAGE_INVALID_OR_EMPTY_FIELD;
    header("location: forgot_password_confirm_new_password.php?token=" . $token); // deal with invalid input
    exit();
}

$password = ltrim(rtrim(filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING)));
if (empty($password))
{
    $_SESSION["error_message"] = $ERROR_MESSAGE_INVALID_OR_EMPTY_FIELD;
    header("location: forgot_password_confirm_new_password.php?token=" . $token); // deal with invalid input
    exit();
}

$confirmPassword = ltrim(rtrim(filter_input(INPUT_POST, "confirmPassword", FILTER_SANITIZE_STRING)));
if (empty($confirmPassword))
{
    $_SESSION["error_message"] = $ERROR_MESSAGE_INVALID_OR_EMPTY_FIELD;
    header("location: forgot_password_confirm_new_password.php?token=" . $token); // deal with invalid input
    exit();
}


/* Validate input data */
if ($password != $confirmPassword)
{
    $_SESSION["error_message"] = $ERROR_MESSAGE_PASSWORDS_DO_NOT_MATCH;
    header("location: forgot_password_confirm_new_password.php?token=" . $token);
    exit();
}


/* Connect to the database */
require_once "configuration.php";



/* Connect to the database */
$dbConnection = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUsername, $dbPassword);
$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   // set the PDO error mode to exception



/* Check that the user is in the pending users database */
$query = "SELECT token, email, expiry_time_stamp FROM pending_users WHERE token = :token AND email = :email AND expiry_time_stamp > :expiry_time_stamp";
$statement = $dbConnection->prepare($query);
$statement->bindParam(":token", $token, PDO::PARAM_STR);
$statement->bindParam(":email", $email, PDO::PARAM_STR);
$statement->bindParam(":expiry_time_stamp", $_SERVER["REQUEST_TIME"], PDO::PARAM_INT);
$statement->execute();

if ($statement->rowCount() == 0)
{
    $_SESSION["error_message"] = $ERROR_MESSAGE_INVALID_OR_EMPTY_FIELD;
    header("location: forgot_password_confirm_new_password.php?token=" . $token); // deal with invalid input
    exit();
}


/* remove this record and all old pending users from database */
$query = "DELETE FROM pending_users WHERE email = :email";
$statement = $dbConnection->prepare($query);
$statement->bindParam(":email", $email, PDO::PARAM_STR);
$statement->execute();


/* remove all old pending users from database */
$query = "DELETE FROM pending_users WHERE expiry_time_stamp < :expiry_time_stamp";
$statement = $dbConnection->prepare($query);
$statement->bindParam(":expiry_time_stamp", $_SERVER["REQUEST_TIME"], PDO::PARAM_INT);
$statement->execute();


/* change the user's password */
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
$query = "UPDATE users SET password = :password WHERE email = :email";
$statement = $dbConnection->prepare($query);
$statement->bindParam(":password", $hashedPassword, PDO::PARAM_STR);
$statement->bindParam(":email", $email, PDO::PARAM_STR);
$statement->execute();


header("location: members_area.php");
?>        
</body>
</html>