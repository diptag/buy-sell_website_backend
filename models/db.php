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

    // function to upload new product data to the database
    function upload_product($name, $description, $category_id, $price, $img_ext)
    {
        $dbh = $GLOBALS["dbh"];

        // use transaction to upload product data and get name to be used for image form the database
        $dbh->beginTransaction();


        // prepare insert statement 
        $stmt = $dbh->prepare("INSERT INTO products (name, description, price, category_id, user_id, datetime) VALUES (:name, :description, :price, :category_id, {$_SESSION["id"]}, NOW())");
        
        // bind values
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":description", $description);
        $stmt->bindParam(":price", $price);
        $stmt->bindParam("category_id", $category_id);

        // excecute statement
        if ($stmt->execute())
        {
            // set status of insert true 
            $status = true;
        }
        else
        {
            $status = false;
        }
        
        // get product id
        
        // get last product id
        $result = $dbh->query("SELECT MAX(id) AS last FROM products");
        $id = $result->fetch(PDO::FETCH_ASSOC);

        // create full image name
        $img = $id["last"].".".$img_ext;
        
        // insert image name in database
        if ($dbh->exec("UPDATE products SET image = '{$img}' WHERE id = {$id["last"]}"))
        {
            $status = true;
            $dbh->commit();
        }
        else
        {
            $status = false;
        }
        
        // return image name and insert status
        return ["status" => $status, "img" => $img, "product_id" => $id["last"]];
    }

    // function to get product data for given product id
    function get_product_data($id) 
    {
        $dbh = $GLOBALS["dbh"];

        // prepare query, bind id and execute it
        $stmt = $dbh->prepare("SELECT products.*, users.name AS user_name, users.email, colleges.name AS college, categories.name AS category FROM products 
        INNER JOIN users ON products.user_id = users.id INNER JOIN colleges ON users.college_id = colleges.id 
        INNER JOIN categories ON products.category_id = categories.id WHERE products.id = :id"); 
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        return $product;
    }

    // get recently added products of all categories or of a particular category from the database 
    function get_recent_products($category_id = null) 
    {
        $dbh = $GLOBALS["dbh"];        
            
        // check if $category_id is passed as argument
        if ($category_id === null)
        {
            // get recent additions of all categories
            $result = $dbh->query("SELECT products.*, categories.name AS category FROM products INNER JOIN categories ON products.category_id = categories.id ORDER BY datetime DESC");
            $products = $result->fetchAll(PDO::FETCH_ASSOC);
        }
        else
        {
            // get recent additions of the given category
            $stmt = $dbh->prepare("SELECT products.*, categories.name AS category FROM products INNER JOIN categories ON products.category_id = categories.id 
                WHERE products.category_id = :id ORDER BY datetime DESC");
            $stmt->bindParam(":id", $category_id);
            $stmt->execute();
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return $products;
    }
?>
