$(function ()
{
    var errorSet = false;
    var forbidenWords = ["Fuck you", "Cunt", "9/11", "Allah Akbar"];

    function messageBox9(data)
    {
        if (errorSet === false)
        {
            $("#errorText").html("");
            $('.messageDiv').slideToggle(0, 'swing');
            $('.messageDiv').slideToggle(0, 'swing');
            $('.messageDiv').slideToggle(1000, 'swing');
            errorSet = true;

            $(".messageDiv").css("display", "block");
            $("#errorText").html(data);
        } else
        {
            $("#errorText").html("");
            $('.messageDiv').slideToggle(1000, 'swing');
            $('.messageDiv').slideToggle(1000, 'swing');



            $('.messageDiv').promise().done(function ()
            {

                $(".messageDiv").css("display", "block");
                $("#errorText").html(data);
            });


        }




    }

    $(".error_close").click(function ()
    {
        $('.messageDiv').slideToggle(1000, 'swing');
        $("#errorText").html("");
        errorSet = false;
    });

    function loadComments()
    {
        $.ajax({
            url: 'viewComments.php',
            type: 'POST',

            success: function (data)
            {
                if (data === "Comments have been disabled by the author on this post.")
                {
                    $("#commentContainer").html(data);
                }
                var jsonData = JSON.parse(data);
                var htmlString = '<div class="comment">';



                for (var i = 0; i < jsonData.length; i++)
                {
                    htmlString += '<div class="comment-header d-flex justify-content-between"><div class="user d-flex align-items-center"><div class="image"><img src="' + jsonData[i].commentImage + '" alt="..." class="img-fluid rounded-circle"></div><div class="title"><strong>' + jsonData[i].name + '</strong><span class="date">' + jsonData[i].date + '</span></div></div></div><div class="comment-body"><p>' + jsonData[i].content + '</p></div></div>';
                }

                if (jsonData.length < 1)
                {
                    htmlString = '<div class="comment">No comments yet!<div class="comment-header d-flex justify-content-between"><div class="user d-flex align-items-center"></strong><span class="date"></span></div></div><div class="comment-body"><p></p></div></div>';
                }


                $('#commentContainer').html(htmlString);

            },
            error: function ()
            {
                dataType: 'text';
            }
        });
    }

    loadComments();

    $("#commentSubmit").click(function ()
    {
        var content = $("#usercomment").val();


        function containsAny(str, substrings)
        {
            for (var i = 0; i != substrings.length; i++)
            {
                var substring = substrings[i];
                if (str.indexOf(substring) != -1)
                {
                    return true;
                }
            }
            return false;
        }

        var badword = containsAny(content, forbidenWords);

        if (badword === true)
        { 
            grecaptcha.reset();
            $("#usercomment").val("");
            messageBox9(content + " contains a forbiden word");
            $('body').scrollTop(0);
        } else
        { 
            var captcha = grecaptcha.getResponse();

            $.ajax({
                url: 'addComments.php',
                type: 'POST',
                data: {'content': content, 'captcha': captcha},

                success: function (data)
                {
                    if (data === "Please fill in the captcha" || data === "Comments cannot be blank." || data === "Comments have been disabled by the author on this post." || data === "You must be logged in to comment.")
                    {
                        messageBox9(data);
                        $('body').scrollTop(0);

                        if (data === "Comments have been disabled by the author on this post.")
                        {
                            $("#commentContainer").html(data);
                        }
                    } else
                    {
                        grecaptcha.reset();
                        $("#usercomment").val("");
                        loadComments();
                    }

                },
                error: function ()
                {
                    dataType: 'text';
                }
            });
        }
    });
});
$(document).ready(function ()
{
    $(document).on('click', '.show_more', function ()
    {
        
        var ID = $(this).attr('id');
        $('.show_more').hide();
        $('.loding').show();
        $.ajax({
            type: 'POST',
            url: 'ajax_more.php',
            data: 'id=' + ID,
            success: function (html)
            { 
                $('#show_more_main' + ID).remove();
                $('#commentContainer').append(html);
            }
        });
    });
});
