$(document).ready(function () {
    $(".country").keyup(function () {
        var query = $(".country").val();
        //console.log(query);
//validate query
        if (query.length > 0) {
            $.ajax({
                url: 'includes/readCountry.php',
                type: 'POST',
                data: {'query': query
                },
//                response: getCounties(),
                success: function (data) {
                    $('#countryList').fadeIn();
                    $('#countryList').html(data);
                },
                error: function () {
                    dataType: 'text';
                }
            });
        }
    });

    $(document).on('click', '#countryList li', function () {
        $('.country').val($(this).text());
        //console.log($(this).text());
        $('#countryList').fadeOut();
    });

    $(document).on('click', '#countyList li', function () {
        $('.county').val($(this).text());
        $('#countyList').fadeOut(); 
    });


    $(".county").keyup(function () {
        var country = $(".country").val();
        var county = $(this).val();
//            console.log(county);

        if (county.length > 0) {
            $.ajax({
                url: 'includes/readCounty.php',
                type: 'POST',
                data: {'country': country, 'county': county
                },
                success: function (data) {
                    $('#countyList').fadeIn();
                    $('#countyList').html(data);
                },
                error: function () {
                    dataType: 'text';
                }
            });
        }

    });

    $(".town").keyup(function () {
        var town = $(this).val(); 
        
        $.ajax({
            url: 'includes/readTown.php',
            type: 'POST',
            data: {town: town
            },

            success: function (data) {
//                        console.log(data);
                $('#townList').fadeIn();
                $('#townList').html(data);
            },
            error: function () {
                dataType: 'text';
            }
        }); 
     
    $(".hide").removeClass("hide");

});

$(document).on('click', '#townList li', function () {
        $('.town').val($(this).text());
        //console.log($(this).text());
        $('#townList').fadeOut();
    });

});

