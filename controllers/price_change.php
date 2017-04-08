<?php
    // send content type header
    header("Content-Type: application/json");
    
    // validate data received
    if (empty($_GET["product_id"]) || empty($_GET["new_price"]))
    {
        // send status false
        print(json_encode(["status" => false, "error_msg" => "All fields are mandatory."], JSON_PRETTY_PRINT));
        exit();
    }
    
    if (intval($_GET["new_price"]) < 0)
    {
        // send status false
        print(json_encode(["status" => false, "error_msg" => "Price should be greater than or equal to 0."], JSON_PRETTY_PRINT));
        exit();   
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
