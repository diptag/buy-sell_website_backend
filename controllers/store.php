<?php
    // get categories from the database
    $categories = get_categories();
    
    // get all colleges form the database
    $colleges = get_colleges();

    // check if category is specified or not 
    if (empty($_GET["category"]))
    {
        // get recent addtions of all categories
        $products = get_recent_products();
    }
    else
    {
        // get recent additions of the given category
        $products = get_recent_products($_GET["category"]);
    }

    // render store view
    render("store_view", ["title" => "Store", "categories" => $categories, "colleges" => $colleges, "products" => $products]);
?>
