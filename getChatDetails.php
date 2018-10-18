<?php
session_start();

require_once 'configuration.php';

$id = $_SESSION['user_id']; 
$name = $_SESSION["user_name"]; 
 
$dbConnection = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUsername, $dbPassword);
$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   // set the PDO error mode to exception
 
echo $name;
?> 