var country;
var town;
var date;
var description;
var id;

$(document).ready(function ()
{
    $("#visited1").click(function ()
    {
        $('#buttonPress').click();

        id = "visited1";


        $("#go").click(function ()
        {
            getAjaxDetails();
        });


    });

    $("#visited2").click(function ()
    {
        $('#buttonPress').click();

        id = "visited2";


        $("#go").click(function ()
        {
            getAjaxDetails();
        });
    });

    $("#visited3").click(function ()
    {
        $('#buttonPress').click();

        id = "visited3";


        $("#go").click(function ()
        {
            getAjaxDetails();
        });
    });

    $("#visited4").click(function ()
    {
        $('#buttonPress').click();

        id = "visited4";


        $("#go").click(function ()
        {
            getAjaxDetails();
        });
    });

    $("#visited5").click(function ()
    {
        $('#buttonPress').click();

        id = "visited5";


        $("#go").click(function ()
        {
            getAjaxDetails();
        });
    });

    $("#visited6").click(function ()
    {
        $('#buttonPress').click();

        id = "visited6";


        $("#go").click(function ()
        {
            getAjaxDetails();
        });
    });


    $("#detailsCountry").keyup(function ()
    {
        country = $("#detailsCountry").val();
    });

    $("#detailsTown").keyup(function ()
    {
        town = $("#detailsTown").val();
    });

    $("#detailsDescription").keyup(function ()
    {
        description = $("#detailsDescription").val();
    });



    function getAjaxDetails()
    {
        alert(id);
        $.ajax({
            url: 'updateUserProfileInfo.php',
            type: 'POST',
            data: {'country': country, 'town': town, 'date': date, 'description': description, 'contentId': id},

            success: function (data)
            {
                if(id === "visited1")
                alert(data);
                $("#visited1").html(data);
            },
            error: function ()
            {
                dataType: 'text';
            }
        });
    } 
});
