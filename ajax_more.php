<?php
session_start();
if(!empty($_POST["id"])){

    // Include the database configuration file
    $db = new mysqli("localhost", "root", "", "blogusers");
    
    
    
    // Count all records except already displayed
    $query = $db->query("SELECT COUNT(*) as num_rows FROM comments WHERE id < ".$_POST['id']." AND blogId = ". $_SESSION["currentId"] ." ORDER BY id DESC");
    $row = $query->fetch_assoc();
    $totalRowCount = $row['num_rows'];
    
    $showLimit = 2;
    
    // Get records from the database
    $query = $db->query("SELECT * FROM comments WHERE id < ".$_POST['id']." AND blogId = ". $_SESSION["currentId"] ." ORDER BY id DESC LIMIT $showLimit");

    if($query->num_rows > 0){ 
        while($row = $query->fetch_assoc()){
            $postID = $row['id'];
    ?>
        <div class="comment"><div class="comment-header d-flex justify-content-between"><div class="user d-flex align-items-center"><div class="image"><img src="<?php echo $row["commentImage"] ?>" alt="..." class="img-fluid rounded-circle"></div><div class="title"><strong><?php echo $row["name"]  ?></strong><span class="date"><?php echo $row["date"] ?></span></div></div></div><div class="comment-body"><p><?php echo $row["content"] ?></p></div></div> 
    <?php } ?>
    <?php if($totalRowCount > $showLimit){ ?>
        <div class="show_more_main" id="show_more_main<?php echo $postID; ?>">
            <span id="<?php echo $postID; ?>" class="show_more" style="cursor: pointer" title="Load more comments"Show more</span>
            <span class="loding" style="display: none;"><span class="loding_txt">Loading...</span></span>
        </div>
    <?php } ?>
<?php
    }
}
?>