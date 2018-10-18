<?php
session_start();

require_once 'configuration.php';

$blogId = $_SESSION["currentId"];
$userId = $_SESSION["user_id"];

$dbConnection = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUsername, $dbPassword);
$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   // set the PDO error mode to exception 



$testQuery = "SELECT comments FROM blogs WHERE id=:id";
$testStatement = $dbConnection->prepare($testQuery);
$testStatement->bindParam(":id", $blogId, PDO::PARAM_INT);
$testStatement->execute();
$res = $testStatement->fetch();

$isCommentAllowed = $res["comments"];

if ($isCommentAllowed == 1) {


$query = "SELECT * FROM comments WHERE blogId = $blogId ORDER BY id DESC LIMIT 4";
$statement = $dbConnection->prepare($query);
$statement->execute();  

$json = "[";
if ($statement->rowCount() > 0)
{
    /* Get field information for all fields */
    $isFirstRecord = true;
    $result = $statement->fetchAll(PDO::FETCH_OBJ);
    foreach ($result as $row)
    {
        if(!$isFirstRecord)
        {
            $json .= ",";
        }
        
        /* NOTE: json strings MUST have double quotes around the attribute names, as shown below */
        $json .= '{"name":"' . $row->name . '","content":"' . $row->content  . '","date":"' . $row->date.'","blogId":"' . $row->blogId . '","userId":"' . $row->userId  . '","commentImage":"' . strval($row->commentImage)  . '"}';
        
        $isFirstRecord = false;
    }  
}     
$json .= "]";

$statement->closeCursor();
echo $json; 
}
else
{
    echo 'Comments have been disabled by the author on this post.';
}