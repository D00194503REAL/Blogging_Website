var email;
var errorSet = false; 

if ($('.messageDivClear').is(':visible'))
{ //if the container is visible on the page
    $('.messageDivClear').slideToggle(0, 'swing');
    $('.messageDivClear').slideToggle(1000, 'swing');



    setTimeout(function ()
    {
        $('.messageDivClear').slideToggle(1000, 'swing');
    }, 6500);
}

$("#email").keyup(function ()
{
    email = $("#email").val();
});

$("#confirmEmail").keyup(function ()
{
    confirmEmail = $("#confirmEmail").val();
});

function messageBoxEmail(data)
{
    if (errorSet === false)
    {
        $("#errorText").html("");
        $('.messageDiv').slideToggle(0, 'swing');
        $('.messageDiv').slideToggle(0, 'swing');
        $('.messageDiv').slideToggle(1000, 'swing');

        $('.messageDiv').promise().done(function ()
        {
            errorSet = true;

            $(".messageDiv").css("display", "block");
            $("#errorText").html(data);
        });



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






$("#emailRegister").click(function (e)
{
    if (email !== confirmEmail)
    {
        e.preventDefault();

        var message = "Emails do not match, please try again!";
        messageBoxEmail(message);
    }
});

$("#email").blur(function ()
{
    if (email.indexOf("@") !== -1)
    {
        $.ajax({
            url: 'emailvalidation.php',
            type: 'POST',
            data: {'email': email},

            success: function (data)
            {
                if (data === email + " is an invalid email format")
                {
                    messageBoxEmail(data);
                } else if (data === email + " has been taken ")
                {
                    messageBoxEmail(data);
                } else
                {
                    messageBoxEmail(data);
                }
            },
            error: function ()
            {
                dataType: 'text';
            }
        });
    }
}); 