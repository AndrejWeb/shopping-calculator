$(document).ready(function() {

    function showCurrency(currency, currency_place) {
        switch(currency_place) {
            case "currency_before":
                $(".c_before").text(currency);
                $(".c_after").text("");
                break;

            case "currency_after":
                $(".c_after").text(currency);
                $(".c_before").text("");
                break;

            default:
                $(".c_after").hide();
                $(".c_before").show();
                break;
        }
    }

    function getCurrency() {
        if(custom_currency.val() != "") {
            return custom_currency.val();
        } else return currency.val();
    }

    function calculateTotal() {
        var total = 0;
        $(".price").each(function() {
            if($(this).val() != "") {
                total += parseFloat($(this).val());
            }
        });
        $("#total").val(total.toFixed(2).replace(/\.00/, ''));
    }

    var custom_currency = $("#custom_currency");
    var currency = $("#currency");

    $(".price").numeric();
    $("#add_item").click(function() {
        var ajax_url = 'add_item.php';

        $.post(ajax_url, { token:$('#token').val() }, function(data) {
            console.log(data);
            $("#items").append(data);
            $(".price").numeric();
            showCurrency(getCurrency(), $(".currency_place:checked").val());
        });
    });
    currency.change(function() {
        showCurrency(getCurrency(), $(".currency_place:checked").val());
    });

    $(".currency_place").click(function() {
        showCurrency(getCurrency(), $(this).val());
    });

    $(document).on("click", ".delete_item", function() {
        if(confirm("Are you sure you want to delete this item?")) {
            $(this).parent().parent().remove();
            calculateTotal();
        }
    });

   $(document).on("keyup", ".price", function() {
        calculateTotal();
    });

    custom_currency.keyup(function() {
       if($.trim($(this).val())) {
           showCurrency(custom_currency.val(), $(".currency_place:checked").val());
       }
    });

    $(".export").click(function() {
        $("#export").val($(this).attr("id"));
        $("#calcForm").submit();
    });

    $("#clear_custom_currency").click(function() {
        custom_currency.val("");
        showCurrency(getCurrency(), $(".currency_place:checked").val());
    });

});
