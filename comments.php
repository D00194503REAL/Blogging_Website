<?php 
session_start();
require_once "configuration.php";

$blogId = $_SESSION["blogId"];

/* Connect to the database */
$dbConnection = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUsername, $dbPassword);
$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   // set the PDO error mode to exception

$query = "SELECT commentsCount FROM blogs WHERE id = :id";
$statement = $dbConnection->prepare($query);
$statement->bindParam(":id", $blogId, PDO::PARAM_STR);
$statement->execute();
$res = $statement ->fetch();
$statement ->closeCursor();

echo $res["commentsCount"]; 
?>
 