<?php
    /* 
     * PHP script to display full data of individual product
     */

    // check if product id is set in $_GET
    if (empty($_GET["id"]))
    {
        // redirect ot store
        redirect("/store");
    }
    
    // get product details form the database
    $product = get_product_data($_GET["id"]);

    // check if product data is found or not 
    if ($product["id"] !== null)
    {
        // render product view
        render("product_view", ["title" => $product["name"], "product" => $product]);
    }
    else
    {
        // render product view page with the msg not found
        render("product_view", ["title" => "Product Not Found", "msg" => "Product Not Found"]);
    }
?>
