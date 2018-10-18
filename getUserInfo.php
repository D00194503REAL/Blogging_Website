<?php
session_start();

require_once 'configuration.php';

$id = $_SESSION['user_id'];  
 
$dbConnection = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUsername, $dbPassword);
$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   // set the PDO error mode to exception

$query = "SELECT name, country, town FROM users WHERE id = :id";
$statement = $dbConnection->prepare($query);
$statement->bindParam(":id", $id, PDO::PARAM_STR);
$statement->execute(); 

if ($statement->rowCount() > 0)
{
    /* Get field information for all fields */
    $result = $statement->fetchAll(PDO::FETCH_OBJ);
    foreach ($result as $row)
    {
        
        echo '' . $row->name . '<h3 class="h3" id="userTown">' . $row->town . ', ' . $row->country  . '</h3>';
        /* NOTE: json strings MUST have double quotes around the attribute names, as shown below */
    }  
}     
?> 