<?php
    /*
     * Contains functions to query and insert into database
     */    

    // read contents of the configuration file
    $contents = file_get_contents("../config.json");

    // decode json file
    $config = json_decode($contents, true);

    // connect to database
    try
    {
        $dbh = new PDO("mysql:host=".$config["database"]["host"].";dbname=".$config["database"]["name"], 
        $config["database"]["username"], $config["database"]["password"]);
    }
    catch( PDOException $e)
    {
        
    }

    // create get user details function
    function get_usr($email)
    {
        // get databse connection handler form $GLOBALS
        $dbh = $GLOBALS["dbh"];

        // prepare sql query
        $usr = $dbh->prepare("SELECT * FROM users WHERE email = :email");

        // bind parameters and execute query
        $usr->bindParam(":email", $email);
        $usr->execute();

        // extract user data 
        $rows = $usr->fetch(PDO::FETCH_ASSOC);

        // return user data
        return $rows;
    }

    // create register user function
    function register_usr($email, $name, $college, $pwd)
    {
        $dbh = $GLOBALS["dbh"];

        // prepare sql statement
        $query = $dbh->prepare("INSERT INTO users (email, name, college_id, hash) VALUES (:email, :name, :college, :hash)");

        // create hash from password
        $hash = password_hash($pwd, PASSWORD_DEFAULT);

        // bind parameters to the query
        $query->bindParam(":email", $email);
        $query->bindParam(":name", $name);
        $query->bindParam(":college", $college); 
        $query->bindParam(":hash", $hash);

        // execute query
        $status = $query->execute();
        
        // return insert status
        if ($status)
            return true;
        else
            return false;
    }
    
    // function to get list of all colleges from the database
    function get_colleges() 
    {
        $dbh = $GLOBALS["dbh"];

        $clgs = $dbh->query("SELECT * FROM colleges");
        $colleges = $clgs->fetchAll(PDO::FETCH_ASSOC);
        return $colleges;
    }

    // function to get all the categories form the database
    function get_categories()
    {
        $dbh = $GLOBALS["dbh"];

        $result = $dbh->query("SELECT * FROM categories");
        $categories = $result->fetchAll(PDO::FETCH_ASSOC);
        return $categories;
    }

    // get recently added products form the database
    function get_recent()
    {
        $dbh = $GLOBALS["dbh"];

        // get products from the database
        //
    }

    // function to upload new product data to the database
    function upload_product($name, $description, $category_id, $price, $img_ext)
    {
        $dbh = $GLOBALS["dbh"];

        // use transaction to upload product data and get name to be used for image form the database
        $dbh->beginTransaction();

        // get last product id
        $result = $dbh->query("SELECT MAX(id) AS last FROM products");
        $last_id = $result->fetch(PDO::FETCH_ASSOC);

        // use last product id + 1 as product image name
        $img_name = $last_id["last"] + 1;

        // prepare insert statement 
        $stmt = $dbh->prepare("INSERT INTO products (name, description, image, price, category_id, user_id, datetime) VALUES (:name, :description, :img, :price, :category_id, {$_SESSION["id"]}, NOW())");

        // bind values
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":description", $description);
        $stmt->bindParam(":img", $img_name.".".$img_ext);
        $stmt->bindParam(":price", $price);
        $stmt->bindParam("category_id", $category_id);

        // excecute statement
        if ($stmt->execute())
        {
            // set status of insert true and commit 
            $status = true;
            $dbh->commit();
        }
        else
        {
            $status = false;
        }

        // return image name and insert status
        return ["status" => $status, "img_name" => $img_name];
    }
?>
