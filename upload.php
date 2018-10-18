<?php

session_start();
require_once 'functions.php';
require_once 'error_messages.php';

if (isset($_POST["submit"])) {
    $image = $_FILES['image']['tmp_name'];
    $name = $_FILES["image"]["name"];
    $filepath = "avatar/$name";

    if (exif_imagetype($image) != IMAGETYPE_PNG) {
        $_SESSION["error_message"] = $ERROR_MESSAGE_WRONG_IMAGE_FORMAT;
        header('Location: ' . "userProfile.php");
        exit();
    }

    if ($_FILES["image"]["size"] > 15000000) {
        $_SESSION["error_message"] = $ERROR_MESSAGE_IMAGE_SIZE_TOO_BIG;
        header('Location: ' . "userProfile.php");
        exit();
    }




    move_uploaded_file($image, $filepath);

    /*
     * Insert image data into database
     */

    //DB details
    $dbHost = 'localhost';
    $dbUsername = 'root';
    $dbPassword = '';
    $dbName = 'blogusers';

    //Create connection and select DB
    $db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

    // Check connection
    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }

    $id = mysqli_real_escape_string($db, $_SESSION["user_id"]);
    //Insert image content into database

    $insert = uploadImage($name, $db, $id);

    if ($insert) {
        header('Location: ' . "userProfile.php");
    } else {
        echo "File upload failed, please try again.";
    }
} else {
    echo 'wtf';
}
?>