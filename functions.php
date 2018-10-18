<?php

require_once 'configuration.php';
require_once "error_messages.php"; 

$conn = mysqli_connect('localhost', 'root', '', 'blogusers');

function newPendingUser($dbConnection, $token, $email, $expiry_time_stamp) {
    /* Check that user is not already user_added  */
    $query = "SELECT email FROM users WHERE email = :email";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(":email", $email, PDO::PARAM_STR);
    $statement->execute();

    if ($statement->rowCount() > 0) {
        $_SESSION["error_message"] = $ERROR_MESSAGE_EMAIL_ALREADY_REGISTERED;
        header("location: register_new_user.php");
        exit();
    }


    /* Check that the user is not already pending */
    $query = "DELETE FROM pending_users WHERE email = :email";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(":email", $email, PDO::PARAM_STR);
    $statement->execute();


    /* Create new pending user */
    $expiry_time_stamp = 1200 + $_SERVER["REQUEST_TIME"]; // 1200 = 20 minutes from now
    $token = sha1(uniqid($email, true));

    $query = "INSERT INTO pending_users (token, email, expiry_time_stamp) VALUES (:token, :email, :expiry_time_stamp)";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(":token", $token, PDO::PARAM_STR);
    $statement->bindParam(":email", $email, PDO::PARAM_STR);
    $statement->bindParam(":expiry_time_stamp", $expiry_time_stamp, PDO::PARAM_INT);
    $statement->execute();


    /* remove all old pending users from database */
    $query = "DELETE FROM pending_users WHERE expiry_time_stamp < :expiry_time_stamp";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(":expiry_time_stamp", $_SERVER["REQUEST_TIME"], PDO::PARAM_INT);
    $statement->execute();
}

function getId($dbConnection) {
    /* get user id */
    $query = "SELECT email FROM users WHERE email = :email";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(":email", $email, PDO::PARAM_STR);
    $statement->execute();


    if ($statement->rowCount() > 0) {
        $result = $statement->fetchAll(PDO::FETCH_OBJ);
        foreach ($result as $row) {
            $_SESSION["user_id"] = $row->id;
            header("location: index.php");
        }
    }
}

function registerNewUser($dbConnection, $email, $token, $password, $name, $country, $county, $town, $description) {
    $accessLevel = 2;
    $image = "avatar/base.png";

    /* Check that user is not already added */
    $query = "SELECT email FROM users WHERE email = :email";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(":email", $email, PDO::PARAM_STR);
    $statement->execute();

    /* Check that the user is in the pending users database */
    $query = "SELECT token, email, expiry_time_stamp FROM pending_users WHERE token = :token AND email = :email AND expiry_time_stamp > :expiry_time_stamp";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(":token", $token, PDO::PARAM_STR);
    $statement->bindParam(":email", $email, PDO::PARAM_STR);
    $statement->bindParam(":expiry_time_stamp", $_SERVER["REQUEST_TIME"], PDO::PARAM_INT);
    $statement->execute();


    /* remove this record from database */
    $query = "DELETE FROM pending_users WHERE email = :email";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(":email", $email, PDO::PARAM_STR);
    $statement->execute();


    /* remove all old pending users from database */
    $query = "DELETE FROM pending_users WHERE expiry_time_stamp < :expiry_time_stamp";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(":expiry_time_stamp", $_SERVER["REQUEST_TIME"], PDO::PARAM_INT);
    $statement->execute();


    /* create hash */
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO users (email, name, password, access_level, country, county, town, image, description) VALUES (:email, :name, :password, :access_level, :country, :county, :town, :image, :description)";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(":email", $email, PDO::PARAM_STR);
    $statement->bindParam(":name", $name, PDO::PARAM_STR);
    $statement->bindParam(":password", $hashedPassword, PDO::PARAM_STR);
    $statement->bindParam(":access_level", $accessLevel, PDO::PARAM_INT);
    $statement->bindParam(":country", $country, PDO::PARAM_STR);
    $statement->bindParam(":county", $county, PDO::PARAM_STR);
    $statement->bindParam(":town", $town, PDO::PARAM_STR);
    $statement->bindParam(":image", $image, PDO::PARAM_STR);
    $statement->bindParam(":description", $description, PDO::PARAM_STR);
    $statement->execute();
}


function uploadImage($name, $db, $id) {

    $insert = $db->query("UPDATE users SET image = 'avatar/$name' WHERE id = '$id'");
    return $insert;
}

function verifyCaptcha($token, $response) {
    if ($response['success'] == false) {

        $newURL = "register_new_user.php";
        header('Location: ' . $newURL);
    } else {
        $siteName = "http://localhost/AndreaWebsite";
        $newURL = $siteName . '/confirm_registration.php?token=' . $token;
        header('Location: ' . $newURL);
    }
}

function userExists($dbConnection, $email) {
    $exists = null;
    $query = "SELECT email FROM users WHERE email='$email'";
    $statement = $dbConnection->prepare($query);
    $statement->execute();

    if ($statement->rowcount() != null) {
        $exists = true;
    } else if ($statement->rowcount() == null) {
        $exists = false;
    }

    return $exists;
}

function addViews($dbConnection, $id) {
    $query = "UPDATE blogs SET views = views + 1 WHERE id = :id";
    $statementAdd = $dbConnection->prepare($query);
    $statementAdd->bindParam(":id", $id, PDO::PARAM_INT);
    $statementAdd->execute();
    $statementAdd->closeCursor();
}

function showCommentsCount($dbConnection, $id) {
    $query = "SELECT commentsCount FROM blogs WHERE id = :id";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(":id", $id, PDO::PARAM_STR);
    $statement->execute();
    $res = $statement->fetch();
    $statement->closeCursor();
    
    return $res["commentsCount"];
}

function displayLatestBlogs() {
    $query = "SELECT * FROM blogs ORDER BY id ASC LIMIT 3";
    $statement = $dbConnection->prepare($query);
    $statement->execute();
    $statement->closeCursor();

    if ($statement->rowCount() > 0) {
        $result = $statement->fetchAll(PDO::FETCH_OBJ);
        foreach ($result as $row) {
            $_SESSION["user_id"] = $row->id;
            header("location: index.php");
        }
    }

    return test;
}

function getEmail($email) {
    global $dbConnection;
    $query = "SELECT email FROM users WHERE email = :email";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(":email", $email, PDO::PARAM_STR);
    $statement->execute();

    return $statement;
}

function pagination($query, $per_page = 10, $page = 1, $url = '?') {

    $db_username = 'root'; // Your MYSQL Username.
    $db_password = ''; // Your MYSQL Password.
    $db_name = 'blogusers'; // Your Database name.
    $db_host = 'localhost';

    $conDB = mysqli_connect($db_host, $db_username, $db_password, $db_name)or die('Error: Could not connect to database.');

    $query = "SELECT COUNT(*) as `num` FROM {$query}";
    $row = mysqli_fetch_array(mysqli_query($conDB, $query));
    $total = $row['num'];
    $adjacents = "2";

    $prevlabel = "&lsaquo; Prev";
    $nextlabel = "Next &rsaquo;";
    $lastlabel = "Last &rsaquo;&rsaquo;";

    $page = ($page == 0 ? 1 : $page);
    $start = ($page - 1) * $per_page;

    $prev = $page - 1;
    $next = $page + 1;

    $lastpage = ceil($total / $per_page);

    $lpm1 = $lastpage - 1; // //last page minus 1

    $pagination = "";
    if ($lastpage > 1) {
        $pagination .= "<ul class='pagination'>";
        $pagination .= "<li class='page_info'>Page {$page} of {$lastpage}</li>";

        if ($page > 1)
            $pagination .= "<li><a href='{$url}page={$prev}'>{$prevlabel}</a></li>";

        if ($lastpage < 7 + ($adjacents * 2)) {
            for ($counter = 1; $counter <= $lastpage; $counter++) {
                if ($counter == $page)
                    $pagination .= "<li><a class='current'>{$counter}</a></li>";
                else
                    $pagination .= "<li><a href='{$url}page={$counter}'>{$counter}</a></li>";
            }
        } elseif ($lastpage > 5 + ($adjacents * 2)) {

            if ($page < 1 + ($adjacents * 2)) {

                for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
                    if ($counter == $page)
                        $pagination .= "<li><a class='current'>{$counter}</a></li>";
                    else
                        $pagination .= "<li><a href='{$url}page={$counter}'>{$counter}</a></li>";
                }
                $pagination .= "<li class='dot'>...</li>";
                $pagination .= "<li><a href='{$url}page={$lpm1}'>{$lpm1}</a></li>";
                $pagination .= "<li><a href='{$url}page={$lastpage}'>{$lastpage}</a></li>";
            } elseif ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {

                $pagination .= "<li><a href='{$url}page=1'>1</a></li>";
                $pagination .= "<li><a href='{$url}page=2'>2</a></li>";
                $pagination .= "<li class='dot'>...</li>";
                for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                    if ($counter == $page)
                        $pagination .= "<li><a class='current'>{$counter}</a></li>";
                    else
                        $pagination .= "<li><a href='{$url}page={$counter}'>{$counter}</a></li>";
                }
                $pagination .= "<li class='dot'>..</li>";
                $pagination .= "<li><a href='{$url}page={$lpm1}'>{$lpm1}</a></li>";
                $pagination .= "<li><a href='{$url}page={$lastpage}'>{$lastpage}</a></li>";
            } else {

                $pagination .= "<li><a href='{$url}page=1'>1</a></li>";
                $pagination .= "<li><a href='{$url}page=2'>2</a></li>";
                $pagination .= "<li class='dot'>..</li>";
                for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
                    if ($counter == $page)
                        $pagination .= "<li><a class='current'>{$counter}</a></li>";
                    else
                        $pagination .= "<li><a href='{$url}page={$counter}'>{$counter}</a></li>";
                }
            }
        }

        if ($page < $counter - 1) {
            $pagination .= "<li><a href='{$url}page={$next}'>{$nextlabel}</a></li>";
            $pagination .= "<li><a href='{$url}page=$lastpage'>{$lastlabel}</a></li>";
        }

        $pagination .= "</ul>";
    }

    return $pagination;
}

function getLikes($id)
{
  global $conn;
  $sql = "SELECT COUNT(*) FROM rating_info 
  		  WHERE post_id = $id AND rating_action='like'";
  $rs = mysqli_query($conn, $sql);
  $result = mysqli_fetch_array($rs);
  return $result[0];
} 
// Get total number of likes and dislikes for a particular post
function getRating($id)
{
  global $conn;
  $rating = array();
  $likes_query = "SELECT COUNT(*) FROM rating_info WHERE post_id = $id AND rating_action='like'";
  $dislikes_query = "SELECT COUNT(*) FROM rating_info 
		  			WHERE post_id = $id AND rating_action='dislike'";
  $likes_rs = mysqli_query($conn, $likes_query);
  $dislikes_rs = mysqli_query($conn, $dislikes_query);
  $likes = mysqli_fetch_array($likes_rs);
  $dislikes = mysqli_fetch_array($dislikes_rs);
  $rating = [
  	'likes' => $likes[0],
  	'dislikes' => $dislikes[0]
  ];
  return json_encode($rating);
}

// Check if user already likes post or not
function userLiked($post_id)
{
  global $conn; 
  $userId = $_SESSION["user_id"]; 
  $sql = "SELECT * FROM rating_info WHERE user_id=$userId 
  		  AND post_id=$post_id AND rating_action='like'";
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) > 0) {
  	return true;
  }else{
  	return false;
  }
} 
