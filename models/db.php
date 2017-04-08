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
        render("msg", ["title" => "Error", "msg" => "Error: Couldn't connect to the databse."]);    
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

        // execute query and return status
        return $status = $query->execute();
    }
    
    // function to get user's password only
    function get_password()  
    {
        $dbh = $GLOBALS["dbh"];
        
        // get password 
        $result = $dbh->query("SELECT hash FROM users WHERE id = ".$_SESSION["id"]);
        $hash = $result->fetch(PDO::FETCH_ASSOC);
        
        return $hash["hash"];
    }
    
    // function to change user password
    function update_password($new) 
    {
        $dbh = $GLOBALS["dbh"];

        // prepare update statement and update password
        $stmt = $dbh->prepare("UPDATE users SET hash = :newhash WHERE id = ".$_SESSION["id"]);
        $stmt->bindParam(":newhash", password_hash($new, PASSWORD_DEFAULT));
        return $stmt->execute();
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
    
    // function to remove product data from database
    function remove_product($product_id)
    {
        $dbh = $GLOBALS["dbh"];
        
        // remove product
        $dbh->query("DELETE FROM products WHERE id = ".$product_id);
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

    // function to get recently added products
    function get_recent_products() 
    {
        $dbh = $GLOBALS["dbh"];        
            
        $result = $dbh->query("SELECT products.*, categories.name AS category, colleges.name AS college FROM products 
        INNER JOIN categories ON products.category_id = categories.id INNER JOIN colleges ON 
        colleges.id = (SELECT college_id FROM users WHERE users.id = products.user_id) ORDER BY datetime DESC");
        $products = $result->fetchAll(PDO::FETCH_ASSOC);
            
        return $products;
    }
    
    // fucntion to get products by category or college or user depending on the option provided
    function get_products_by($option, $id = null)
    {
        $dbh = $GLOBALS["dbh"];
        
        // prepare query and bind value
        if ($option === 1)
        {
            // get priducts by category
            $stmt = $dbh->prepare("SELECT products.*, categories.name AS category, colleges.name AS college FROM products 
            INNER JOIN categories ON products.category_id = categories.id INNER JOIN colleges ON colleges.id 
            IN (SELECT college_id FROM users WHERE users.id = products.user_id) 
            WHERE products.category_id = :id && products.sold = 'n' ORDER BY datetime DESC");
        }
        else if ($option === 2)
        {  
            // get products by college
            $stmt = $dbh->prepare("SELECT products.*, categories.name AS category, colleges.name AS college FROM products 
            INNER JOIN categories ON products.category_id = categories.id INNER JOIN colleges ON 
            colleges.id = (SELECT college_id FROM users WHERE users.id = products.user_id) 
            WHERE products.user_id IN (SELECT id FROM users WHERE users.college_id = :id) && products.sold = 'n' ORDER BY datetime DESC");
        }
        else if ($option === 3)
        {
            // get products by user_id
            $stmt = $dbh->prepare("SELECT products.*, categories.name AS category FROM products INNER JOIN categories 
            ON products.category_id = categories.id WHERE products.user_id = ".$_SESSION["id"]." ORDER BY sold");
        }
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $products;
    }
    
    // function to update price
    function update_price($product_id, $new_price)
    {
        $dbh = $GLOBALS["dbh"];
        
        // prepare update statement
        $stmt = $dbh->prepare("UPDATE products SET price = :new_price WHERE id = :product_id");
        
        // bind values and execute 
        $stmt->bindParam(":new_price", $new_price);
        $stmt->bindParam(":product_id", $product_id);
        if ($stmt->execute())
            return true;
        else
            return false;
    }
    
    // fucntion to update sold status
    function update_status($product_id)
    {
        $dbh = $GLOBALS["dbh"];
        
        // prepare update statement
        $stmt = $dbh->prepare("UPDATE products SET sold = 'y' WHERE id = :product_id");
        
        // bind product id and execute 
        $stmt->bindParam(":product_id", $product_id);
        if($stmt->execute())
            return true;
        else
            return false;
    }
?>