$(document).ready(function () {

//    if ($('.messageDivClear').is(':visible')) { //if the container is visible on the page
//        setTimeout(function ()
//        {
//            $(".messageDivClear").fadeOut(1600);
//        }, 5000);
//    }



    $.ajax({

        url: 'getUserInfo.php',
        type: 'POST',

        success: function (data)
        {
            //var jsonParser = JSON.parse(data);
            //alert(jsonParser["name"]);
            $("#name").html(data);
        },
        error: function ()
        {
            dataType: 'text';
        }
    });

}); 