<?php 
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    }  
include 'functions.php';
$conn = mysqli_connect('localhost', 'root', '', 'blogusers');

// lets assume a user is logged in with id $user_id
  $userId = $_SESSION["user_id"];
  $blogId = $_SESSION["currentId"];

if (!$conn) {
  die("Error connecting to database: " . mysqli_connect_error($conn));
  exit();
}

// if user clicks like or dislike button
if (isset($_POST['action'])) { 
  $action = $_POST['action']; 
  switch ($action) {
  	case 'like':
         $sql="INSERT INTO rating_info (user_id, post_id, rating_action) 
         	   VALUES ($userId, $blogId, 'like') 
         	   ON DUPLICATE KEY UPDATE rating_action='like'";
         break;
  	case 'dislike':
          $sql="INSERT INTO rating_info (user_id, post_id, rating_action) 
               VALUES ($userId, $blogId, 'dislike') 
         	   ON DUPLICATE KEY UPDATE rating_action='dislike'";
         break;
  	case 'unlike':
	      $sql="DELETE FROM rating_info WHERE user_id=$userId AND post_id=$blogId";
	      break;
  	case 'undislike':
      	  $sql="DELETE FROM rating_info WHERE user_id=$userId AND post_id=$blogId";
      break;
  	default:
  		break;
  }

  // execute query to effect changes in the database ...
  mysqli_query($conn, $sql);
  echo getRating($blogId);
  exit(0);
}

        