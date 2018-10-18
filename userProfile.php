<?php
if (!isset($_SESSION["user_id"])) {
    session_start();
    if (!isset($_SESSION["user_id"])) {
        header("location: index.php");
    }

    require_once 'configuration.php';
    
    $connect = mysqli_connect("localhost", "root", "", "blogusers");
    
    $dbConnection = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUsername, $dbPassword);
    $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   // set the PDO error mode to exception    

    $id = $_SESSION["user_id"];

    $query = "SELECT description FROM users WHERE id=$id";
    $statement = $dbConnection->prepare($query);
    $statement->execute();
    $res = $statement->fetch();
    $statement->closeCursor(); 
}
?>
<?php
include_once 'header.php';
include_once 'functions.php';
?>


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
    max-width: 100%;
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
?>   





<div class="sheath">
    <div id="body-wrapper1">

        <div class="name" id="name"><h3 class="h3" id="userTown"></h3>,<h3 class="h3" id="userCountry"> </h3></div>

        <div class="row1">    
            <div class="content1">
                <div class="me" id="imgFileUpload"></div>

                <div class="info">
                    <form style="display: none;" action="upload.php" method="post" enctype="multipart/form-data"> 
                        <input name="image" type="file" id="FileUpload1" style="display: none" accept="image/x-png"/>
                        <input type="submit" id="FileUpload2" name="submit" value="Yes" style="display: none"/> 
                    </form>
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

                            <div class="post-thumbnail"><a href="post.php?id=<?php echo $row["id"]; ?>"><img src="<?php echo $row["image"]; ?>" style="max-height: 200px;" alt="..." class="img-fluid"></a></div>
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
                                <footer class="post-footer d-flex align-items-center"><a href="#" class="author d-flex align-items-center flex-wrap">
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
<script src="js/ajaxGetUserDetails.js" type="text/javascript"></script>
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