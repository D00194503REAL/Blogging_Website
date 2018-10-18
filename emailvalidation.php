<?php

require_once 'configuration.php';
require_once 'functions.php';

$email = $_POST['email'];
$validEmail = null;

if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $validEmail = true;
} else {
    echo $email . ' is an invalid email format';
    exit();
}

$dbConnection = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUsername, $dbPassword);
$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   // set the PDO error mode to exception


$statement = getEmail($email);
//$query = "SELECT email FROM users WHERE email = :email";
//$statement = $dbConnection->prepare($query);
//$statement->bindParam(":email", $email, PDO::PARAM_STR);
//$statement->execute();

$output = "";

while ($row = $statement->fetch()) {
    //   $return_arr[] = $row['country];
    $output .= $row["email"];
}

if ($validEmail) {
    if ($email !== $output) {
        echo $email . ' is available';
    } else {
        echo $email . ' has been taken';
    }
}
?> 