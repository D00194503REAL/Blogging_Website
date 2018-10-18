<?php
session_start();

// if it exists, then destroy any previous session 
session_unset();
session_destroy();
session_start();


/* Read posted data */
require_once "error_messages.php";  // contains a list of error messages that can be assigned to $_SESSION["error_message"]
  
$preEmail = $_POST['email'];

$email = filter_var($preEmail, FILTER_SANITIZE_EMAIL);
if (empty($email) || (!filter_var($email, FILTER_VALIDATE_EMAIL)))
{
    echo 'Input contained invalid or empty fields.';
    exit();
}

$prePassword = $_POST['password'];

$password = filter_var($prePassword, FILTER_SANITIZE_STRING); 
if (empty($password))
{ 
    echo "Input contained invalid or empty fields.";
    exit();
}


/* Connect to the database */
require_once "configuration.php";



/* Connect to the database */
$dbConnection = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUsername, $dbPassword);
$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   // set the PDO error mode to exception



/* Check that user exists  */
$query = "SELECT id, name, password FROM users WHERE email = :email";
$statement = $dbConnection->prepare($query);
$statement->bindParam(":email", $email, PDO::PARAM_STR);
$statement->execute();


if ($statement->rowCount() > 0)
{
    $row = $statement->fetch(PDO::FETCH_OBJ);

    if (!password_verify($password, $row->password))
    {  
        echo 'Input contained invalid or empty fields.';
        exit();
    } 
}
else
{
    echo 'No users with the email ' . $email . ' where found in our database.';
    exit();
}


// keep password up-to-date
if (password_needs_rehash($password, PASSWORD_DEFAULT))
{
    // the password needs to be rehashed as it is not up-to-date
    $new_password = password_hash($password, PASSWORD_DEFAULT);

    // update the hash in the database
    $query = "UPDATE users SET password = :password WHERE id = :id";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(":password", $new_password, PDO::PARAM_STR);
    $statement->bindParam(":id", $_SESSION["user_id"], PDO::PARAM_INT);
    $statement->execute();
}


// set session variables
$_SESSION["user_id"] = $row->id;
$_SESSION["user_name"] = $row->name;

// keep password up-to-date
if (password_needs_rehash($row->password, PASSWORD_DEFAULT))
{
    // the password needs to be rehashed as it is not up-to-date
    $new_password = password_hash($password, PASSWORD_DEFAULT);

    // update the hash in the database
    $query = "UPDATE users SET password = :password WHERE id = :id";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(":password", $new_password, PDO::PARAM_STR);
    $statement->bindParam(":id", $_SESSION["user_id"], PDO::PARAM_INT);
    $statement->execute();
}


// Note that if the password fails, then the members_area.php webpage will automatically redirect the user back to the login webpage
echo "Login Successful!";
?>