<?php
if (!isset($_SESSION["user_id"])) {
    if(!isset($_GET["userId"]))
    {
        header("location: index.php");
    }
    session_start(); 

    require_once 'configuration.php';
    
    $connect = mysqli_connect("localhost", "root", "", "blogusers");
    
    $dbConnection = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUsername, $dbPassword);
    $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   // set the PDO error mode to exception    

    $id = $_GET["userId"];

    $query = "SELECT description FROM users WHERE id=$id";
    $statement = $dbConnection->prepare($query);
    $statement->execute();
    $res = $statement->fetch();
    $statement->closeCursor(); 
}
?>
<?php 
include_once 'functions.php';
?>






<?php
require_once 'configuration.php';

    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 

if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
    // last request was more than 30 minutes ago
    session_unset();     // unset $_SESSION variable for the run-time 
    session_destroy();   // destroy session data in storage
    header("location: index.php");
}
$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp

$dbConnection = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUsername, $dbPassword);
$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   // set the PDO error mode to exception
?> 
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1"> 
        <link href="css/errorDiv.css" rel="stylesheet" type="text/css"/>
        <link href="css/chatBox.css" rel="stylesheet" type="text/css"/>
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
        <!--===============================================================================================-->	
        <link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
        <!--===============================================================================================-->	
        <link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="css/util.css">
        <link rel="stylesheet" type="text/css" href="css/main.css">
        <!--===============================================================================================-->
        <link rel="icon" type="image/png" href="img/travblog.png">
        <!-- Bootstrap CSS-->
        <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
        <!-- Font Awesome CSS-->
        <link rel="stylesheet" href="vendor/font-awesome/css/font-awesome.min.css">
        <!-- Custom icon font-->
        <link rel="stylesheet" href="css/fontastic.css">
        <!-- Google fonts - Open Sans-->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700">
        <!-- Fancybox-->
        <link rel="stylesheet" href="vendor/@fancyapps/fancybox/jquery.fancybox.min.css">
        <!-- theme stylesheet-->
        <link rel="stylesheet" href="css/style.default.css" id="theme-stylesheet">
        <!-- Custom stylesheet - for your changes-->
        <link rel="stylesheet" href="css/custom.css">
        <!-- Favicon-->
        <link rel="shortcut icon" href="favicon.png">

        <style>
<?php
$dbHost = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'blogusers';

//Create connection and select DB
$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName); 

if(isset($_SESSION["user_id"]))
{ 
    $result = $db->query("SELECT image FROM users WHERE id='". $_SESSION["user_id"] ."'");
    
    if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        $path2 = $row["image"];
    }
}
} 
$result = $db->query("SELECT image FROM users WHERE id='$id'");
 
if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        $path = $row["image"];
    }
}
?>      
        
            .me {
                cursor: pointer;
                opacity: 0;
                height: 160px;
                width: 160px;
                border-radius: 80px;
                margin: 0 auto;
                background:  url(<?php echo $path ?>) center; 
                background-size: cover;
                border: 2px white solid;
                margin-top: -80px;
                position: relative; 
                -webkit-animation: fadein .5s ease-in .8s forwards;
                -moz-animation: fadein .5s ease-in .8s forwards;
                -ms-animation: fadein .5s ease-in .8s forwards;
                -o-animation: fadein .5s ease-in .8s forwards;
                animation: fadein .5s ease-in .8s forwards;
            }
        </style>
    </head>
    <body class="body1"> 
        <!-- Main Navbar-->
        <nav class="navbar navbar-expand-lg">
            <div class="search-area">
                <div class="search-area-inner d-flex align-items-center justify-content-center">
                    <div class="close-btn"><i class="icon-close"></i></div>
                    <div class="row d-flex justify-content-center">
                        <div class="col-md-8">
                            <form action="#">
                                <div class="form-group">
                                    <input type="search" name="search" id="search" placeholder="What are you looking for?">
                                    <button type="submit" class="submit"><i class="icon-search-1"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <!-- Navbar Brand -->
                <div class="navbar-header d-flex align-items-center justify-content-between">
                    <!-- Navbar Brand --><a href="index.php" class="navbar-brand">Travelbook</a>
                    <!-- Toggle Button-->
                    <button type="button" data-toggle="collapse" data-target="#navbarcollapse" aria-controls="navbarcollapse" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler"><span></span><span></span><span></span></button>
                </div>
                <!-- Navbar Menu -->
                <div id="navbarcollapse" class="collapse navbar-collapse">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item"><a href="index.php" class="nav-link ">Home</a>
                        </li> 
                        <li class="nav-item"><a href="addBlogForm.php" class="nav-link ">
                                <?php
                                if (isset($_SESSION["user_name"])) {

                                    echo "Add Blog";
                                }
                                ?></a></li> 
                                <?php if (isset($_SESSION["user_name"])) {
                                    ?><li class="nav-item"><a href="userProfile.php" class="nav-link ">Profile</a></li><?php }
                                ?>

                        </li> 
                        <li class="nav-item"><?php
                        if (isset($_SESSION["user_name"])) {
                            ?><a href="logout_transaction.php" class="nav-link ">Logout</a><?php
                        } else {
                            ?>
                                <a href="login.php" class="nav-link ">Login</a>
                                <?php
                            }
                            ?>
                        </li>
                    </ul>

                    <li class="nav-item"><a href="userProfile.php" class="nav-link ">
                            <?php
                            if (isset($_SESSION["user_name"])) {

                                echo $_SESSION["user_name"];
                            }
                            ?></a></li> 
                    <?php if (isset($_SESSION["user_name"])) { ?><div class="navbar-text"><a href="userProfile.php"><img src="<?php echo $path2 ?>" style="border-radius: 50%;" width="32" height="32" alt=""/></a></div> <?php }?>
                </div>
            </div>
        </nav>









<style>
    .wrap { text-align:center; line-height:21px; padding:20px; }
/* For pagination function. */
ul.pagination {
    text-align:center;
    color:#829994;
}
ul.pagination li {
    display:inline;
    padding:0 3px;
}
ul.pagination a {
    color:#0d7963;
    display:inline-block;
    padding:5px 10px;
    border:1px solid #cde0dc;
    text-decoration:none;
}
ul.pagination a:hover,
ul.pagination a.current {
    background:#0d7963;
    color:#fff;
}
.col-lg-8
{
    flex:1;
    max-width: 100%
}
.wrap
{
    margin-left: 25%;
}
</style>
<?php
$db_username = 'root'; // Your MYSQL Username.
$db_password = ''; // Your MYSQL Password.
$db_name = 'blogusers'; // Your Database name.
$db_host = 'localhost';
 
$conDB = mysqli_connect($db_host, $db_username, $db_password,$db_name)or die('Error: Could not connect to database.');

// Pagination Function
?>
<title>Profile</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
<link href="css/detailsField.css" rel="stylesheet" type="text/css"/>
<link href="css/jquery-ui.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="css/userStyle.css">
<link href="css/wickedpicker.css" rel="stylesheet" type="text/css"/>
<?php
/* Show error message for any user input errors if this form was previously submitted */
if (isset($_SESSION["error_message"])) {

    echo '<div class="messageDivClear"><a class="error_close"><b>x</b></a><div class="error_container"><b id="errorText">' . $_SESSION["error_message"] . '</b></div></div>';

    unset($_SESSION["error_message"]);
}

$results = mysqli_query($conDB,"SELECT name, country, town FROM users WHERE id = $id"); 
?>    


<div class="sheath">
    <div id="body-wrapper1">
<?php while ($row = mysqli_fetch_array($results)) {?>
<div class="name" id="name"><?php echo $row["name"] ?><h3 class="h3" id="userTown"><?php echo $row["town"]?>,</h3><h3 class="h3" id="userCountry"><?php echo $row["country"] ?></h3></div><?php }?>

        <div class="row1">    
            <div class="content1">
                <div class="me" style="cursor: auto;"></div>

                <div class="info"> 
                    <p style="color: white;" id="description">
<?php echo $res["description"]; ?>
                    </p>
                </div>
            </div> 
        </div>   
 


        <br><br>
       <div class="container">
    <div class="row">
        <!-- Latest Posts -->
        <main class="posts-listing col-lg-8"> 
            <div class="container">
                <div class="row" id="myTable" style="background-color: white;">







<?php
$description = substr($row["content"], 0, 160)."...";
$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
if ($page <= 0) $page = 1;

$per_page = 6; // Set how many records do you want to display per page.

$startpoint = ($page * $per_page) - $per_page;

$statement = "`blogs` WHERE userId = $id  ORDER BY `id` desc"; // Change `records` according to your table name.
 
$results = mysqli_query($conDB,"SELECT * FROM {$statement} LIMIT {$startpoint} , {$per_page}");
while ($row = mysqli_fetch_array($results)) {
                            $query4 = "SEELCT tag FROM blogs";
                        $result4 = mysqli_query($connect, $query4);
                        
                        
                        $array = array("review,books,fiction");
                        $newArray = explode(',', implode(' ', $array));
                        
                        $string = str_replace(',', ' #', $row['tag']);
                        $string = rtrim($string,'#');
                        $description = substr($row["content"], 0, 160)."...";
                        
    ?>  
                        <!-- post -->
                        <div class="post col-xl-6" style="background-color: white;">

                            <div class="post-thumbnail"><a href="post.php?id=<?php echo $row["id"]; ?>"><img src="<?php echo $row["image"]; ?>" alt="..." class="img-fluid"></a></div>
                            <div class="post-details">
                                <div class="post-meta d-flex justify-content-between">
                                    <div class="date meta-last"><h7><?php echo $row["date"]; ?></h7></div>
                                     <div class="category"><h4><?php
                                                if (!empty($row["tag"])) {
                                                    foreach ($newArray as $x) { 
                                                    echo '<a>#' . $x . '</a>';
                                                    }
                                                }
                                                ?></h4></div>
                                </div><a href="post.php?id=<?php echo $row["id"]; ?>">
                                    <h3 class="h4"><?php echo $row["title"]; ?></h3></a>
                                <p class="text-muted"><?php echo $description; ?></p>
                                <footer class="post-footer d-flex align-items-center"><a class="author d-flex align-items-center flex-wrap">
                                        <div class="avatar"><div class="avatar"><img src="<?php echo $row["uploaderImage"] ?>" alt="..." class="img-fluid"></div></div>
                                        <div class="title"><span><?php echo $row["name"]; ?></span></div></a>
                                    <div class="date"><i class="icon-clock"></i> 
    <?php
    $a = new \DateTime($row["date"]);
    $b = new \DateTime;

    $years = $a->diff($b)->days / 365;
    $months = $a->diff($b)->days / 30;
    $days = $a->diff($b)->days;

    if (floor($years) != 0) {
        echo floor($years);
        echo ' year ago';
    } else if (floor($months) != 0) {
        echo floor($months);
        echo ' months ago';
    } else {
        echo floor($days);
        echo ' days ago';
    }
    ?>
                                    </div>
                                    <div class="comments meta-last"><i class="icon-eye"></i>&nbsp;<?php echo $row["views"]; ?></div>
                                </footer>
                            </div>

                        </div>

    <?php
}
?>  



    <div class="wrap">

<?php 
echo pagination($statement,$per_page,$page,$url='?');
?> 
</div><!-- .wrap -->


                   
            </div> 
        </aside>
    </div>
</div>
</div>

        <br><br><br><br>
    </div></div>







<?php
require_once 'footerUserProfile.php';
?>
</body>   
<script src="js/errorJS.js" type="text/javascript"></script> 
<script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
<script  src="js/jquery-ui.js"></script>	
<script  src="js/wickedpicker.js"></script>	

<script type="text/javascript">
                            $(function ()
                            {
                                $("#datepicker,#datepicker1,#datepicker2").datepicker();
                            });
</script> 
<script src="js/addPlace.js" type="text/javascript"></script>
</html>