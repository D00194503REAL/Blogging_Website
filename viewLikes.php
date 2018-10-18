<?php

require_once 'configuration.php';
session_start();

$blogId = $_SESSION["currentId"];


$dbConnection = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUsername, $dbPassword);
$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   // set the PDO error mode to exception 

$query2 = "SELECT likes FROM blogs WHERE id = $blogId";
$statement2 = $dbConnection->prepare($query2);
$statement2->execute();
$res = $statement2->fetch();
$statement2->closeCursor();

echo $res["likes"];
