var errorSet = false;

$(function() {
    $.ajax({
        url: 'viewLikes.php',
        type: 'POST',
        data: {'action': "like"},

        success: function (data)
        {
            $('#likeCount').html(" " + data);
        },
        error: function ()
        {
            dataType: 'text';
        }
    });
});   

function messageBox5(data)
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
    $("#errorText").html("");
    $('.messageDiv').slideToggle(1000, 'swing');
    errorSet = false;
});
    
$("#like").click(function ()
{

    $.ajax({
        url: 'like.php',
        type: 'post',

        success: function (data)
        {
            if (data == "Please log in to like")
            { 
                messageBox5(data);
            } else
            {  
                $('#likeCount').html(" " + data);
            }

        },
        error: function ()
        {
            dataType: 'text';
        }
    });


});