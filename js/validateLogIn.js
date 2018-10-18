var email;
var password;
var errorSet = false;

$("#loginEmail").keyup(function ()
{
    email = $("#loginEmail").val();
});

$("#loginPassword").keyup(function ()
{
    password = $("#loginPassword").val();
});







function messageBox(data)
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

$("#login").submit(function (e)
{
    e.preventDefault();

    $.ajax({

        url: 'login_transaction.php',
        type: 'POST',
        data: {'email': email, 'password': password},

        success: function (data)
        {
            if (data === 'No users with the email ' + email + ' where found in our database.')
            {
                messageBox(data);
            } else if (data === "Input contained invalid or empty fields.")
            {
                messageBox(data);
            } else if (data === "Login Successful!")
            {
                //window.location.replace("index.php");
                $(location).attr('href', 'index.php');
            } else
            {
                messageBox("Something went wrong, please try again!");
            }
        },
        error: function ()
        {
            dataType: 'text';
        }
    });

});
