<?php

require_once 'configuration.php';
require_once 'error_messages.php';
session_start();

$blogId = $_SESSION["currentId"];
$userId = $_SESSION["user_id"];

if(!isset($userId))
{
    echo 'You must be logged in to comment.';
    exit();
}


$comment = $_POST['content'];
$date = date("Y-m-d");
$captcha = $_POST["captcha"];

$dbConnection = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUsername, $dbPassword);
$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   // set the PDO error mode to exception 

$testQuery = "SELECT comments FROM blogs WHERE id=:id";
$testStatement = $dbConnection->prepare($testQuery);
$testStatement->bindParam(":id", $blogId, PDO::PARAM_INT);
$testStatement->execute();
$res = $testStatement->fetch();

$isCommentAllowed = $res["comments"];

if ($isCommentAllowed == 1) {
    if (empty($comment)) {
        echo "Comments cannot be blank.";
        exit();
    }



    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6Le5lVMUAAAAANvtDq47EalOCXfQgQVr87Yqnrei&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']);
    $obj = json_decode($response);
    if ($obj->success == true) {


        $imageQuery = "SELECT image FROM users WHERE id=:id";
        $imageStatement = $dbConnection->prepare($imageQuery);
        $imageStatement->bindParam(":id", $userId, PDO::PARAM_INT);
        $imageStatement->execute();

        $imageFetch = $imageStatement->fetch();
        $image = $imageFetch["image"];

        $emailQuery = "SELECT email FROM users WHERE id=:id";
        $emailStatement = $dbConnection->prepare($emailQuery);
        $emailStatement->bindParam(":id", $userId, PDO::PARAM_INT);
        $emailStatement->execute();

        $emailFetch = $emailStatement->fetch();
        $email = $emailFetch["email"];

        $nameQuery = "SELECT name FROM users WHERE id=:id";
        $nameStatement = $dbConnection->prepare($nameQuery);
        $nameStatement->bindParam(":id", $userId, PDO::PARAM_INT);
        $nameStatement->execute();

        $nameFetch = $nameStatement->fetch();
        $name = $nameFetch["name"];

        $insertCommentQuery = "INSERT INTO comments (name, content, blogId, userId, commentImage, date) VALUES (:name, :content, :blogId, :userId, :commentImage, :date)";
        $insertCommentStatement = $dbConnection->prepare($insertCommentQuery);
        $insertCommentStatement->bindParam(":name", $name, PDO::PARAM_STR);
        $insertCommentStatement->bindParam(":userId", $userId, PDO::PARAM_INT);
        $insertCommentStatement->bindParam(":blogId", $blogId, PDO::PARAM_INT);
        $insertCommentStatement->bindParam(":content", $comment, PDO::PARAM_STR);
        $insertCommentStatement->bindParam(":commentImage", $image, PDO::PARAM_STR);
        $insertCommentStatement->bindParam(":date", $date, PDO::PARAM_STR);
        $insertCommentStatement->execute();

        $query = "UPDATE blogs SET commentsCount = commentsCount + 1 WHERE id = :id";
        $statementAdd = $dbConnection->prepare($query);
        $statementAdd->bindParam(":id", $blogId, PDO::PARAM_INT);
        $statementAdd->execute();
        $statementAdd->closeCursor();
    } else {
        echo 'Please fill in the captcha';
        exit();
    }
} else {
    echo 'Comments have been disabled by the author on this post.';
}



