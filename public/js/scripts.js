$(document).ready( function() {
    // global variable for storing prodct id and price displayed
    var product_id;
    var price;
    
    // open change price modal
    $(".modal-btn").click( function() {
        price = $(this).parent().children("span");
        product_id = $(this).val();
        $("#price-change-form").children("input[name=old_price]").val(price.text());
        $("#price-change-modal").css("display", "block");
    });
    
    // close the modal
    $(".close").click( function() {
        $("#price-change-modal").css("display", "none");
    });
    
    // when update price form is submitted
    $("#price-change-form").submit( function() {
        var sell_type = $(this).children("input[name=sell_type]:checked").val();
        var new_price = $(this).children("input[name=new_price]").val();
        
        // update the proce in database through ajax
        $.ajax({
            url: "price_change",
            data: {
                product_id: product_id,
                sell_type: sell_type,
                new_price: new_price
            },
            async: false,
            success: function(data) {
                // check if price was changed or not 
                if (data.status === false){
                    // display error alert
                    alert("Cannot update Price.");
                }
            }
        });
    });
    
    // when mark as sold button is clicked
    $(".sold-btn").click( function() {
        // get product id from button
        product_id = $(this).val();
        var status;
        
        // update product status using ajax
        $.ajax({
            url: "mark_sold",
            data: {
                product_id: product_id
            },
            async: false,
            success: function(data) {
                if (data.status === true) {
                    // update status variable
                    status = true;
                }
                else {
                    status = false;
                }
            }
        });
        
        if (status === true) {
            // display sold status as yes in table and remove button
            $(this).parent().text("Yes");
            $(this).css("display", "none");
        }
        else {
            alert("Couldn't update status. Some unexpected error occured.");
        }
    });
    
    // function to disable price input box in sell form if donate is selected
    $("input[type=radio][name=sell_type]").click( function() {
        // check if button is checked
        if ($(this).is(':checked')) {
            // check which button is checked
            if ($(this).val() === "donate") {
                // disable price input box
                $(this).siblings("input[type=number]").attr("disabled", "disabled");
            }
            else if ($(this).val() === "sell") {
                //enable price input box
                $(this).siblings("input[type=number]").removeAttr("disabled");
            }
        }
    });
})