<?php
    // get categories from the database
    $categories = get_categories();
    
    // get all colleges form the database
    $colleges = get_colleges();

    // check if category is specified or not 
    if (empty($_GET["category"]) && empty($_GET["college"]))
    {
        // get recent addtions of all categories
        $products = get_recent_products();
    }
    else if (empty($_GET["college"]))
    {
        // get recent additions of the given category
        $products = get_products_by(1, $_GET["category"]);
    }
    else
    {
        // get recent additons of the given college
        $products = get_products_by(2, $_GET["college"]);
    }

    // render store view
    render("store_view", ["title" => "Store", "categories" => $categories, "colleges" => $colleges, "products" => $products]);
?>
