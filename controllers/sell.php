<?php
    // get categories
    $categories = get_categories();

    // if user reached the page via GET (i.e. by clicking a link or redirect)
    if($_SERVER["REQUEST_METHOD"] == "GET") 
    {
            // render sell_form
            render("sell_form", ["title" => "Sell a Product", "categories" => $categories]);
    }
    // if user reached the page via POST (i.e. by submitting a form)
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // validate user data
        if (empty($_POST["name"]) || empty($_POST["description"]) || empty($_POST["category_id"]) || empty($_POST["price"]))
        {
            // render sell_form with error msg with appropriate error msg
            render("sell_form", ["title" => "Sell a Product", "categories" => $categories, "error_msg" => "All fields are mandatory."]);
        }

        // check if price is valid
        if (intval($_POST["price"]) < 0)
        {
            render("sell_form", ["title" => "Sell a Product", "categories" => $categories, "error_msg" => "Invalid Price."]);
        }

        // check if image has been uploaded 
        if (empty($_FILES))
        {
            render("sell_form", ["title" => "Sell a Product", "categories" => $categories, "error_msg" => "Upload a product image"]);
        }
        
        // check if the size if image is greater than 1mb
        if ($_FILES["image_upload"]["size"] > 1024000)
        {
            render("sell_form", ["title" => "Sell a Product", "categories" => $categories, "error_msg" => "Image file too large"]);
        }

        /*
        // check if the uploaded file is image, is of specified image type 
        $check = getimagesize($_FILES["image_upload"]["tmp_name"]);
        if ($check === false)
        {
            render("sell_form", ["title" => "Sell a Product", "categories" => $categories, "error_msg" => "Invalid image type."]);    
        }
        */
        $allowedTypes = array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF);
        $detectedType = exif_imagetype($_FILES["image_upload"]["tmp_name"]);
        if (!in_array($detectedType, $allowedTypes))
        {
            render("sell_form", ["title" => "Sell a Product", "categories" => $categories, "error_msg" => "Invalid image type."]);
        }

        // get image extension
        $img_ext = pathinfo($_FILES["image_upload"]["name"], PATHINFO_EXTENSION);

        // save the product data in database
        $result = upload_product($_POST["name"], $_POST["description"], $_POST["category_id"], $_POST["price"], $img_ext); 

        // if insert failed
        if ($result["status"])
        {

        }
        
        // set image name and directory 
        $img = $result["img"];
        $img_dir = "img/";

        // mave image file from temporary diretory to img directory
        if (move_uploaded_file($_FILES["image_upload"]["tmp_name"], $img_dir.$img))
        {
            // redirect to the product view page of the uploaded product
            redirect("/product?id=".$result["product_id"]);
        }
        else
        {
            
        }

    }

?>
