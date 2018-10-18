<title>Home</title>
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
    
    #choice1,#choice2,#choice3
    {
  -webkit-appearance: none;
  -moz-appearance: none;
  appearance: none;

  border-radius: 50%;
  width: 16px;
  height: 16px;

  border: 2px solid #999;
  transition: 0.2s all linear;
  outline: none;
  margin-right: 5px;

  position: relative;
  top: 4px;
}

#choice1:checked,#choice2:checked,#choice3:checked {
  border: 6px solid black;
}
</style>
<?php
$db_username = 'root'; // Your MYSQL Username.
$db_password = ''; // Your MYSQL Password.
$db_name = 'blogusers'; // Your Database name.
$db_host = 'localhost';

$x = 1;

$conDB = mysqli_connect($db_host, $db_username, $db_password, $db_name)or die('Error: Could not connect to database.');
?>
<?php
require_once 'header.php';
require_once 'functions.php';

$connect = mysqli_connect("localhost", "root", "", "blogusers");

?>  

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
        <main class="posts-listing col-lg-8"> 
            <div class="container">
                <div class="row" id="myTable">







                    <?php
                    $page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
                    if ($page <= 0)
                        $page = 1;

                    $per_page = 4; // Set how many records do you want to display per page.

                    $startpoint = ($page * $per_page) - $per_page;

                    $statement = "`blogs` WHERE ".$_SESSION['radio1']." like '%".$_SESSION['query']."%' ORDER BY `id` ASC"; // Change `records` according to your table name.

                    $results = mysqli_query($conDB, "SELECT * FROM {$statement} LIMIT {$startpoint} , {$per_page}");


                    while ($row = mysqli_fetch_array($results)) {
                        $string = str_replace(',', ' #', $row['tag']);
                        $string = rtrim($string,'#');
                        $description = substr($row["content"], 0, 160)."...";
                        
                        
                        ?>  
                        <!-- post -->
                        <div class="post col-xl-6">

                            <div class="post-thumbnail"><a href="post.php?id=<?php echo $row["id"]; ?>"><img src="<?php echo $row["image"]; ?>" style="max-height: 200px;" alt="..." class="img-fluid"></a></div>
                            <div class="post-details">
                                <div class="post-meta d-flex justify-content-between">
                                    <div class="date meta-last"><h7><?php echo $row["date"]; ?></h7></div>
                                    <div class="category"><h4><a><?php
                                                if (!empty($row["tag"])) {
                                                    echo '#' . $string;
                                                }
                                                ?></a></h4></div>
                                </div><a href="post.php?id=<?php echo $row["id"]; ?>">
                                    <h3 class="h4"><?php echo $row["title"]; ?></h3></a>
                                <p class="text-muted"><?php echo $description; ?></p>
                                <footer class="post-footer d-flex align-items-center"><a href="#" class="author d-flex align-items-center flex-wrap">
                                        <div class="avatar"><img src="<?php echo $row["uploaderImage"] ?>" alt="..." class="img-fluid"></div>
                                        <div class="title"><span style="font-size: 12px;"><?php echo $row["name"]; ?></span></div></a>
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
                                    </div><div class="views"><i class="icon-comment"></i><?php echo $row["commentsCount"] ?></div>
                                    <div class="comments meta-last"><i class="icon-eye"></i>&nbsp;<?php echo $row["views"]; ?></div>
                                     
                                </footer>
                            </div>

                        </div>

                        <?php
                    }
                    ?>  






                        <div class="wrap" style="position: absolute; display: inline-block; bottom: 5%; left: 25%;">

                        <?php
                        echo pagination($statement, $per_page, $page, $url = '?');
                        ?> 
                    </div><!-- .wrap -->
                    
                    
                    <div class="after"></div>
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
                        <input type="search" placeholder="What are you looking for?" id="myInput" >
                        
                        
                        
    <input type="radio" id="choice1" class="radio1"
           name="contact" value="tag">
    <label for="choice1">Tag</label><br>
    <input type="radio" id="choice2" class="radio1"
           name="contact" value="date">
    <label for="choice2">Date</label><br>
    <input type="radio" id="choice3" class="radio1"
           name="contact" value="content" checked>
    <label for="choice3">Content</label>
    <button type="submit" class="submit" id="subm"><i class="icon-search"></i></button>
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
            <!-- Widget [Categories Widget]-->
            <div class="widget categories">
                <header>
                    <h3 class="h6">Tags</h3>
                </header>
                <?php
                $query = "select tag from blogs";

                $result = mysqli_query($connect, $query);
                
                $arrayString = "";
                
                while ($row = mysqli_fetch_array($result)) {
                    $arrayString .= $row["tag"] . ",";
                }
                
                $array = array($arrayString);
$count = array_count_values(explode(',', implode(' ', $array)));

arsort($count);

$highest5 = array_slice($count, 0, 5);

$tagName;
$tagValue;


                foreach($highest5 as $x => $x_value) {
                    $tagName = $x;
                    $tagCount = $x_value;
                    ?>  
                    <div class="item2 item d-flex justify-content-between"><a href="#"><?php echo '#' . $x ?></a><span><?php echo $x_value?></span></div>
                   
                    <?php
                }
                ?>  
            </div> 
        </aside>
    </div>
</div> 
</div>
<!-- Page Footer-->
<?php
require_once 'footer.php';
?>
</body>
</html>
<script>
    function myFunction() {
        var input, filter, table, tr, td, i, h4, h7;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("myTable");
        tr = table.getElementsByTagName("div");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("h3")[0];
            h4 = tr[i].getElementsByTagName("h4")[0];
            h7 = tr[i].getElementsByTagName("h7")[0];
            if (td) {
                if (td.innerHTML.toUpperCase().indexOf(filter) > -1 || h4.innerHTML.toUpperCase().indexOf(filter) > -1 || h7.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }

            }
        }
    }
    
    var query;
    $("#myInput").keyup(function () {
        query = $("#myInput").val();
    });
    
    var radio1;
    $(".radio1").click( function () {
        if( $(this).is(':checked') ) {radio1 = $(this).val();};
    });

$(document).ready(function ()
{
    $("#subm").click(function (e)
    {
        e.preventDefault();
        $.ajax({
            url:"backend-search.php",
            type: 'POST',
            data: {'query': query, 'radio1': radio1
            },

            success: function () {
                location.href = "search.php"
            },
            error: function () {
                dataType: 'text';
            }
        });
    });
    });
    
    $(".item2").click(function (e){ 
    var tag = $(this).text(); 
    tag = tag.replace("#", "");
    tag = tag.replace(/\d+/g, '')
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