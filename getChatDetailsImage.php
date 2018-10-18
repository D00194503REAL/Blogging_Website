<?php

session_start();

require_once 'configuration.php';

$dbConnection = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUsername, $dbPassword);
$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   // set the PDO error mode to exception


$query = "SELECT image FROM users WHERE id = :id";
$statement = $dbConnection->prepare($query);
$statement->bindParam(":id", $_SESSION["user_id"], PDO::PARAM_INT);
$statement->execute();

$output = "";

if ($statement->rowcount() != null) {
    while ($row = $statement->fetch()) {
        //   $return_arr[] = $row['country];
        $output = $row["image"];
    }
}
    echo $output;
?> 