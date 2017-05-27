(function () {
    $("#edit").on("click", function () {
        $("#edit").addClass("hidden");
        $("#save").removeClass("hidden");
        $(".background").removeAttr("readonly").removeClass("background");

    });

    $("#save").on("click", function () {
        var are_you_sure = confirm("To change login and password?  Are you sure?");
        if (!are_you_sure) {
            location.reload();
        }
    });

    $(".up_price").on("click", function () {
        var val = $(this).attr("value");
        //console.log(val);
        $.ajax({
            url: "../upload/views/upload_all_prices_handler.php",
            type: "POST",
            data: ({count_for_change_price: val}),
            success: function (responseText) {
                /*console.log(responseText);*/
                $("#result").html(responseText);
                $("#loading").addClass("hidden");
            }
        });
        $("#loading").removeClass("hidden");
    });




    $(".upload_description").on("click", function () {
        var val = $(this).attr("value");

        console.log(val);
            $.ajax({
            url: "../upload/add_to_site.php",
            type: "POST",
            data: ({category_id: val}),
            success: function (responseText) {
                //console.log(responseText);
                $("#result_upload_description").html(responseText);
                $("#loading").addClass("hidden");
                $("#back").removeClass("hidden");
            }
        });
        $("#upload_description").addClass("hidden");
        $("#loading").removeClass("hidden");
    });

    $("#back").on("click", function () {
        $("#upload_description").removeClass("hidden");
        $("#back").addClass("hidden");
    });




})();
