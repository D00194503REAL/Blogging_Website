<?php

session_start();
require_once ("configuration.php");


if (isset($_POST['comments'])) {
    if ($_POST['comments'] == '1') {
        $comments = '1';
    } else {
        $comments = '0';
    }
} else {
    $comments = '0';
}







$title = filter_input(INPUT_POST, "title"); 
$content = filter_input(INPUT_POST, "content");
$tag = filter_input(INPUT_POST, "tags-input");
$name = $_SESSION["user_name"];
$date = date("Y-m-d");
$id = $_SESSION["user_id"];

$uploaderImage = $imageBlog = $_FILES['imageBlog']['tmp_name'];
$fileName = $_FILES["imageBlog"]["name"];
$filepath = "avatar/$fileName";

move_uploaded_file($imageBlog, $filepath);

/* Connect to the database */
$dbConnection = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUsername, $dbPassword);
$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   // set the PDO error mode to exception    

$preQuery = "SELECT image FROM users WHERE id=:id";
$preStatement = $dbConnection->prepare($preQuery);
$preStatement->bindValue(":id", $id);
$preStatement->execute();
$res = $preStatement ->fetch();
$userImage = $res["image"];
$preStatement->closeCursor();



$insertQuery = "INSERT INTO blogs (name, title, content, image, tag, date, comments, userId, uploaderImage)"
        . " VALUES (:np_name, :np_title, :np_content, :np_filepath, :np_tag, :np_date, :comments, :userId, :uploaderImage)";
$statement = $dbConnection->prepare($insertQuery);
$statement->bindValue(":np_name", $name);
$statement->bindValue(":np_title", $title); 
$statement->bindValue(":np_content", $content);
$statement->bindValue(":np_filepath", $filepath);
$statement->bindValue(":np_tag", $tag);
$statement->bindValue(":np_date", $date);
$statement->bindValue(":comments", $comments);
$statement->bindValue(":userId", $id);
$statement->bindValue(":uploaderImage", $userImage);
$statement->execute();
$statement->closeCursor();

header('Location: ' . "index.php");
?>

