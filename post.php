
<?php 
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    }  
$_SESSION["currentId"] = $_GET["id"];
include 'like.php'; ?>
<title>Home</title>

<?php
if (!isset($_GET["id"])) {
    header("location: index.php");
} 
?>

<?php
require_once 'header.php';
require_once 'configuration.php';
require_once 'functions.php'; 
?>    
<div class="messageDiv">
    <a class="error_close"><b>x</b></a>
    <div class="error_container"><b id="errorText"></b></div>
    
</div>
<?php if (isset($_SESSION["user_name"])) {
    ?>    <div id="live-chat">

        <header class="clearfix">

            <a class="chat-close">x</a>

            <h4><?php echo $_SESSION["user_name"] ?></h4> 

        </header>

        <div class="chat">

            <div class="chat-history" id="log"></div>   
            <input type="text" id="chatBoxText" placeholder="Type your message…"> 
            <button id="chatBoxButton">Send</button>


        </div> <!-- end chat -->

    </div> <!-- end live-chat -->     <?php }
?>
<div class="container">
    <div class="row">
        <!-- Latest Posts -->
        <?php
        $connect = mysqli_connect("localhost", "root", "", "blogusers");
        addViews($dbConnection, $_GET["id"]);
        $commentsCount = showCommentsCount($dbConnection, $_GET["id"]);
        
        $query = "SELECT * FROM blogs WHERE id = " . $_GET['id'] . " ORDER BY id ASC";

        $result = mysqli_query($connect, $query);
        $row = mysqli_fetch_array($result);


        $query2 = "select title, id from blogs where id >  " . $_GET['id'] . " order by id asc limit 1";
        $result2 = mysqli_query($connect, $query2);

        $query3 = "select title, id from blogs where id <  " . $_GET['id'] . " order by id desc limit 1";
        $result3 = mysqli_query($connect, $query3);

        $query4 = "SELECT tag FROM blogs WHERE id=".$_GET['id']."";
        $result4 = mysqli_query($connect, $query4);

        $result4 = mysqli_fetch_assoc($result4);

        $array = $result4;
        $newArray = explode(',', implode(' ', $array));
        
        ?>  
        <main class="post blog-post col-lg-8"> 
            <div class="container">
                <div class="post-single">
                    <div class="post-thumbnail"><img src="<?php echo $row["image"]; ?>" alt="..." class="img-fluid"></div>
                    <div class="post-details">
                        <div class="post-meta d-flex justify-content-between">
                            <div class="category"><h4><?php
        if (!empty($row["tag"])) {
            foreach ($newArray as $x) {
                echo '<a>#' . $x . '</a>';
            }
        }
        ?></h4></div>
                        </div>
                        <h1><?php echo $row["title"]; ?></h1>
                        <div class="post-footer d-flex align-items-center flex-column flex-sm-row"><a href="#" class="author d-flex align-items-center flex-wrap">
                                <div class="avatar"><img src="<?php echo $row["uploaderImage"] ?>" alt="..." class="img-fluid"></div>
                                <div class="title"><span><?php echo $row["name"]; ?></span></div></a>
                            <div class="d-flex align-items-center flex-wrap">       
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
<div class="views"><i class="icon-eye"></i><?php echo $row["views"] ?></div>
                                <div class="views"><i class="icon-comment"></i><?php echo $row["commentsCount"] ?></div>
                                <div class="comments meta-last" style="color: gray; -webkit-user-select: none; 
    -moz-user-select: none; -khtml-user-select: none; -ms-user-select: none; " id="like"><?php if(isset($_SESSION["user_id"])) { ?><i <?php 
    
  
    if (userLiked($_SESSION["currentId"])): ?>
      		  class="fa fa-thumbs-up like-btn"
      	  <?php else: ?>
      		 style="cursor: pointer;" class="fa fa-thumbs-o-up like-btn"
    <?php endif ?> 
      	  data-id="<?php echo $_SESSION["currentId"] ?>"></i>
      	<span class="likes" style="cursor: default;"><?php echo getLikes($_SESSION["currentId"]); ?></span><?php }  
        
        else {?>
        <i class="fa fa-thumbs-o-up" ></i>
                              <span class="likes"><?php echo getLikes($_SESSION["currentId"]); ?></span><?php }?>
                                
                                </div>
                                
                                
                                
                                
                                
                            </div>
                        </div>
                        <div class="post-body">
                            <p class="lead"><?php echo $row["content"]; ?></p> 
                        </div>
       
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        <?php
    
        if (!empty($row["tag"])) {
            $isFirst = true;
            foreach ($newArray as $x) {
                if($isFirst)
                {
                   echo '<div class="post-tags"><a href="#" class="tag">#' . $x .'</a>';  
                   $isFirst = false;
                }
                else
                { 
                    echo '<a href="#" class="tag">#' . $x .'</a>';
                }
            }
            echo "</div>";
        }
        ?> 
                        

                        

                        <div class="posts-nav d-flex justify-content-between align-items-stretch flex-column flex-md-row">
                            <?php
                            while ($row3 = mysqli_fetch_array($result3)) {
                                if (isset($row3)) {
                                    ?>                            
                                    <a href="post.php?id=<?php echo $row3["id"] ?>" class="prev-post text-left d-flex align-items-center">
                                        <div class="icon prev"><i class="fa fa-angle-left"></i></div>
                                        <div class="text"><strong class="text-primary">Previous Post </strong>
                                            <h6><?php echo $row3["title"] ?></h6>
                                        </div></a>
                                <?php }
                            }
                            ?> 
                            <?php
                            while ($row2 = mysqli_fetch_array($result2)) {
                                if (isset($row2)) {
                                    ?>                     
                                    <a href="post.php?id=<?php echo $row2["id"] ?>" class="next-post text-right d-flex align-items-center justify-content-end">
                                        <div class="text"><strong class="text-primary">Next Post </strong>
                                            <h6><?php echo $row2["title"] ?></h6>
                                        </div>
                                        <div class="icon next"><i class="fa fa-angle-right">   </i></div></a>
                                <?php }
                            }
                            ?>  
                        </div>


                        <div class="post-comments">
                            <header>
                                <h3 class="h6">Post Comments<span class="no-of-comments">(<?php echo $commentsCount?>)</span></h3>
                            </header>
                         <div id="commentContainer"> 



                         </div>
                                                          <?php
    
    // Get records from the database
    $query = $connect->query("SELECT * FROM comments WHERE blogId = ". $_GET["id"] ." ORDER BY id DESC LIMIT 4");
    
    if($query->num_rows > 0){ 
        while($row = $query->fetch_assoc()){ 
            $postID = $row['id'];
    ?>
                         
                             
    <?php } ?>
    <div class="show_more_main" id="show_more_main<?php echo $postID; ?>">
        <span id="<?php echo $postID; ?>" class="show_more" style="cursor: pointer" title="Load more comments">Show more</span>
        <span class="loding" style="display: none;"><span class="loding_txt">Loading...</span></span>
    </div>
    <?php } ?>  
                        </div>
                        <div class="add-comment">
                            <header>
                                <h3 class="h6">Leave a reply</h3>
                            </header>
                            <form class="commenting-form" method="post">
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <textarea name="usercomment" id="usercomment" placeholder="Type your comment" class="form-control" ></textarea>
                                    </div>
                                    <div class="form-group col-md-12">
                                    <div class="g-recaptcha" data-callback="capcha_filled" data-expired-callback="capcha_expired" data-sitekey="6Le5lVMUAAAAAMIl8QNLVCKTSodwrKWqIh7KwJru"></div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <button type="button" class="btn btn-secondary" id="commentSubmit">Submit Comment</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <aside class="col-lg-4">
            <!-- Widget [Search Bar Widget]-->
            <div class="widget search">
                <header>
                    <h3 class="h6">Search the blog</h3>
                </header>
                <form action="#" class="search-form">
                    <div class="form-group">
                        <input type="search" placeholder="What are you looking for?">
                        <button type="submit" class="submit"><i class="icon-search"></i></button>
                    </div>
                </form>
            </div>
            <!-- Widget [Latest Posts Widget]        -->
            <div class="widget latest-posts">
                <header>
                    <h3 class="h6">Latest Posts</h3>
                </header>
                <div class="blog-posts">
                    <?php
                    $query = "SELECT * FROM blogs ORDER BY id DESC LIMIT 3";
                    $result = mysqli_query($connect, $query);
                    while ($row = mysqli_fetch_array($result)) {
                        ?>  
                        <a href="post.php?id=<?php echo $row["id"]; ?>">
                            <div class="item d-flex align-items-center">
                                <div class="image"><img src="<?php echo $row["image"]; ?>" alt="..." class="img-fluid"></div>
                                <div class="title"><strong><?php echo $row["title"]; ?></strong>
                                    <div class="d-flex align-items-center">
                                        <div class="views"><i class="icon-eye"></i><?php echo $row["views"] ?></div>
                                        <div class="comments"><i class="icon-comment"></i><?php echo $row["commentsCount"] ?></div>
                                    </div>
                                </div>
                            </div></a>
                        <?php
                    }
                    ?>  




                </div>
            </div>
        </aside>
    </div>
</div>
<!-- Page Footer-->
<?php
require_once 'footer.php';
?>  
<script src="js/comments.js" type="text/javascript"></script>
</body>
</html>  
<script>
    $(".tag").click(function (e){ 
    var tag = $(this).text(); 
    tag = tag.replace("#", "");
    e.preventDefault();
        $.ajax({
            url:"backend-search.php",
            type: 'POST',
            data: {'query': tag, 'radio1': "tag",
            },

            success: function () {
                location.href = "search.php"
            },
            error: function () {
                dataType: 'text';
            }
        });
});


</script>