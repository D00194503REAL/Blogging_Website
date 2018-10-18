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

$id = mysqli_real_escape_string($db, $_SESSION["user_id"]);

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
                    <?php if (isset($_SESSION["user_name"])) { ?><div class="navbar-text"><a href="userProfile.php"><img src="<?php echo $path ?>" style="border-radius: 50%;" width="32" height="32" alt=""/></a></div> <?php }?>
                </div>
            </div>
        </nav>