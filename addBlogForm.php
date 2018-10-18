<style> 
    #title
    {
        margin-left: 40px;
    }
    h1{
        color: blue-violet;
        text-align: center;
    }

    h3.heading{
        margin-left: 20px;
        background-color: #fafafa;
        font-size: 25px;
        float: left;
        padding-left: 40px;
        position: relative;
        width: 405px;
        height: 40px;
        padding-top: 5px;

    }
    #upper_blank{
        border-bottom: 7px solid steelblue;
        margin-top: 40px;
        margin-right: 485px;
        width: 570px;
        padding-right: 480px;
    }
    p{
        margin-left: 5px;
        padding: 8px;
        padding-left: 20px;
    }
    #title{
        margin-left: 20px;
        box-shadow: 0 2px 0 #e6e6e6;
        height: 40px;
        padding-left: 10px;
        width: 500px;
    }
    #tag{
        margin-left: 20px;
        box-shadow: 0 2px 0 #e6e6e6;
        width: 500px;
    }
    #image
    {
        margin-left: 10px;
        height: 40px;
        padding-left: 10px;
        width: 500px;
    }
    .content{
        margin-left: 20px;
        box-shadow: 0 2px 0 #e6e6e6;
        height: 40px;
        padding-left: 10px;
        width: 650px;
        height: 400px;
    }
    .description
    {
        margin-left: 20px;
        box-shadow: 0 2px 0 #e6e6e6;
        height: 40px;
        padding-left: 10px;
        width: 650px;
        height: 100px;
    }
    #commentSubmit{
        margin-left: 20px;
        width: 250px;
        height: 55px;
        color: white;
        font-size: 20px;
        background-color: #2c95dc;
        box-shadow: 0 3px 0 #09466f;
        margin-bottom: 30px;
        padding-left: 20px;
        border-radius: 5px;
    }
    #commentSubmit:hover {
        background-color: #09466f;

    }

    p{
        font-size: 18px;
        color: gray;
        padding-bottom: 15px;
        padding-top: 15px;
    }
    p1{
        font-size: 18px;
        padding-top: 20px;
    }

    h3.second_heading{
        margin-left: 0;
        margin-top: 30px;
        font-size: 20px;
        width: 250px;
        height: 50px;
        padding-top: 10px;
        padding-left: 55px;

    }
    #middle{
        border: 1px solid lightgray;
        width: 1000px;
        height: 200px;
        background-color: lightyellow;
        margin-left: 45px;
        text-align: left;
        margin-top: 10px;
        box-shadow: 0 2px 0 lightgray;
    }
    .blank{
        border-bottom: 7px solid steelblue;
        margin-top: 50px;
        margin-left: 50px;
        margin-right: 100px;
        width: 800px;
    }

    #inner_reply{

        margin-left: 800px;
        margin-top: 160px;
        width: 100px;
        height: 30px;
        background-color: #2c95dc;
        text-align: center;
        font-size: 18px;
        color: white;
        border-radius: 18px;
    }

    .form-row
    {
        border: 0px solid black;
    }

    #title,.description,.content,#tag
    {
        border-bottom: 1px lightslategray solid;
        border-left: 1px lightslategray solid;
        border-top: 1px lightgray solid;
        border-right: 1px lightgray solid;
        border-radius: 5px;

    }
    
    .tags-input {
    
    display: inline-block;
}

.tags-input .tag {
    font-size: 85%;
    padding: 0.5em 0.75em;
    margin: 0.25em 0.1em;
    display: inline-block;
    background-color: #ddd;
    transition: all 0.1s linear;
    cursor: pointer;
}

.tags-input .tag:hover {
    background-color: #3af;
    color: white;
}

.tags-input .tag .close::after {
    content: '×';
    font-weight: bold;
    display: inline-block;
    transform: scale(1.4);
    margin-left: 0.75em;
}

.tags-input .tag .close:hover::after {
    color: red;
}

.tags-input .main-input {
    border: 0;
    outline: 0;
    padding: 0.5em 0.1em;
    width: 500px;
    border-right: 1px lightgray solid;
    border-radius: 5px;
}
</style>
<title>Home</title>
<?php
require_once 'header.php';
require_once 'error_messages.php';
$connect = mysqli_connect("localhost", "root", "", "blogusers");
?> 


<?php if (isset($_SESSION["user_name"])) {
    ?>    <div id="live-chat">

        <header class="clearfix">

            <a class="chat-close">x</a>

            <h4><?php echo $_SESSION["user_name"] ?></h4> 

        </header>

        <div class="chat">

            <div class="chat-history" id="log">  

            </div>   
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
                <div id="wrap">
                    <div id='form'>
                        <div class="row">
                            <div class="col-md-12">

                                <form action="addBlog.php" method="POST" id="commentform" enctype="multipart/form-data">

                                    <div id="comment-name" class="form-row">
                                        <input type = "text" placeholder = "Title (required)" name = "title"  id = "title" required>
                                    </div>
                                    <br>
                                    <div id="comment-name" class="form-row">
                                        <input name="imageBlog" id="image" type="file" required/>
                                    </div>
                                    <br>
                                    <div id="comment-name" class="form-row">
<!--                                        <input type = "text" placeholder = "Tag (required)" name = "tag"  id = "tag" required>-->
<!--                                        <div id="tag_hide" style="position:absolute; height: 40px; cursor: text;" onclick="hide()">1</div>-->
<div onclick="hide()" id="tag_hide" style="position:absolute; height: 42px; color: lightslategray; margin-left: 30px; margin-top:9px; width: 500px;">Tags (followed by comma)</div>
                                        <div class="tags-input" id="tag" data-name="tags-input"></div>
                                    </div>
                                    
                                    <br>
                                    <div id="comment-message" class="form-row">
                                        <textarea name = "content" placeholder = "Content" maxlength="10000" class="content" id = "max" required></textarea>
                                    </div>
                                    <br>
                                    <input style="width: 30px; float: left; margin-left: 10px;" type="checkbox" value="1" name="comments" id="comments">
                                    <h6>Enable Comments</h6>
                                    <br>
                                    <input type="submit" name="dsubmit" id="commentSubmit" value="Add Blog"> 


                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>


























        </main>
        <aside class="col-lg-4"> 
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
</body> 
<script>

[].forEach.call(document.getElementsByClassName('tags-input'), function (el) {
    let hiddenInput = document.createElement('input'),
        mainInput = document.createElement('input'),
        tags = [];
    
    hiddenInput.setAttribute('type', 'hidden');
    hiddenInput.setAttribute('name', el.getAttribute('data-name'));

    mainInput.setAttribute('type', 'text');
    mainInput.classList.add('main-input');
    mainInput.addEventListener('input', function () {
        let enteredTags = mainInput.value.split(',');
        if (enteredTags.length > 1) {
            enteredTags.forEach(function (t) {
                let filteredTag = filterTag(t);
                if (filteredTag.length > 0)
                    addTag(filteredTag);
            });
            mainInput.value = '';
        }
    });

    mainInput.addEventListener('keydown', function (e) {
        let keyCode = e.which || e.keyCode;
        if (keyCode === 8 && mainInput.value.length === 0 && tags.length > 0) {
            removeTag(tags.length - 1);
        }
    });

    el.appendChild(mainInput);
    el.appendChild(hiddenInput);


    function addTag (text) {
        let tag = {
            text: text,
            element: document.createElement('span'),
        };

        tag.element.classList.add('tag');
        tag.element.textContent = tag.text;

        let closeBtn = document.createElement('span');
        closeBtn.classList.add('close');
        closeBtn.addEventListener('click', function () {
            removeTag(tags.indexOf(tag));
        });
        tag.element.appendChild(closeBtn);

        tags.push(tag);

        el.insertBefore(tag.element, mainInput);

        refreshTags();
    }

    function removeTag (index) {
        let tag = tags[index];
        tags.splice(index, 1);
        el.removeChild(tag.element);
        refreshTags();
    }

    function refreshTags () {
        let tagsList = [];
        tags.forEach(function (t) {
            tagsList.push(t.text);
        });
        hiddenInput.value = tagsList.join(',');
    }

    function filterTag (tag) {
        return tag.replace(/[^\w -]/g, '').trim().replace(/\W+/g, '-');
    }
});


$("#tag_hide").click(function (e)
    {
        $('#tag_hide').css('display', 'none');
  $('#tag_hide').trigger('click');
});


</script>    