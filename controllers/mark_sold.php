<?php
    // send content header 
    header("Content-type: application/json");
    
    //validate data
    if (empty($_GET["product_id"]))
    {
        // send status false
        print(json_encode(["status" => false], JSON_PRETTY_PRINT));
    }
    
    // update product status
    $result = update_status($_GET["product_id"]);
    
    if ($result === true)
    {
        print(json_encode(["status" => true], JSON_PRETTY_PRINT));
    }
    else
    {
        print(json_encode(["status" => false], JSON_PRETTY_PRINT));
    }
?>