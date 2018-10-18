var isGone = false;

if ($('.messageDivClear').is(':visible'))
{ //if the container is visible on the page
    $('.messageDivClear').slideToggle(0, 'swing');
    $('.messageDivClear').slideToggle(1000, 'swing'); 
}

$(".error_close").click(function ()
{
    $("#errorText").html("");
    $('.messageDivClear').slideToggle(1000, 'swing');

    isGone = true;
});

if (isGone)
{
    setTimeout(function ()
    {
        $('.messageDivClear').slideToggle(1000, 'swing');
    }, 6500);
}