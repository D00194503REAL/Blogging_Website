(function ()
{
    var isSet = false;
    $('#live-chat header').on('click', function ()
    {


        if (isSet === false)
        {
            $(".chat-close").text("-");
            isSet = true;
        } else
        {
            $(".chat-close").text("x");
            isSet = false;
        }

        $('.chat').slideToggle(300, 'swing');
        $('.chat-message-counter').fadeToggle(300, 'swing');

    });

})();