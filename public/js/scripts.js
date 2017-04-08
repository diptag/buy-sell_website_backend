$(document).ready( function() {
    
    // global variable for storing prodct id and price displayed
    var product_id;
    var price
    
    $(".modal-btn").click( function() {
        price = $(this).parent().children("span");
        product_id = $(this).val();
        $("#price-change-form").children("input[name=old_price]").val(price.text());
        $("#price-change-modal").css("display", "block");
    });
    
    $(".close").click( function() {
        $("#price-change-modal").css("display", "none");
    });
    
    $("#price-change-form").submit( function() {
        var new_price = $(this).children("input[name=new_price]").val();
        
        // update the proce in database through ajax
        $.ajax({
            url: "price_change",
            data: {
                product_id: product_id,
                new_price: new_price
            },
            async: false,
            success: function(data) {
                // check if price was changed or not 
                if (data.status === true) {
                    // change display price
                    price.text(new_price);
                }
                else {
                    // display error msg
                    alert(data.error_msg);
                }
            }
        });
    });
})