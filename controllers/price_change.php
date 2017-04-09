<?php
    // send content type header
    header("Content-Type: application/json");
    
    // validate data received
    if (empty($_GET["product_id"]) || empty($_GET["sell_type"]))
    {
        // send status false
        print(json_encode(["status" => false, "error_msg" => "All fields are mandatory."], JSON_PRETTY_PRINT));
        exit();
    }
    
    // check wether user has selected donate or sell
        if ($_GET["sell_type"] === "sell")
        {
            // check if user has enterd price or not
            if (empty($_GET["new_price"]))
            {
                print(json_encode(["status" => false, "error_msg" => "All fields are mandatory."], JSON_PRETTY_PRINT));
                exit();
            }
            // if user entered the price check if it is greater than 0 or not
            else if (intval($_GET["new_price"]) <= 0)
            {
                // send status false
                print(json_encode(["status" => false, "error_msg" => "Price should be greater than or equal to 0."], JSON_PRETTY_PRINT));
                exit();
            }
        }
        else if ($_GET["sell_type"] === "donate")
        {
            // set price to be 0
            $_GET["new_price"] = 0;
        }
    
    // update price in the database
    $result = update_price($_GET["product_id"], $_GET["new_price"]);
    
    // check if price was updated
    if ($result === false)
    {
        // send status false and error msg
        print(json_encode(["status" => false, "error_msg" => "Price cannot be updated. Some unexpected error occured."], JSON_PRETTY_PRINT));
        exit();
    }
    else if ($result === true)
    {
        // send status true
        print(json_encode(["status" => true], JSON_PRETTY_PRINT));
        exit();
    }
?>
