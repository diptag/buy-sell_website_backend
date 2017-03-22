<?php
    /*
     * Contains functions to query and insert into database
     */    

    // read contents of the configuration file
    $contents = file_get_contents("../config.json");

    // decode json file
    $config = json_decode($contents, true);

    // connect to databse
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
    function register_usr($email, $name, $institute, $pwd)
    {
        // prepare sql statement
        $query = $dbh->prepare("INSERT INTO users (email, name, institute, hash) VALUES (:email, :name, :institute, :hash)");

        // create hash from password
        $hash = password_hash($pwd, PASSWORD_DEFAULT);

        // bind parameters to the query
        $query->bindParam(":email", $email);
        $query->bindParam(":name", $name);
        $query->bindParam(":institute", $institute); 
        $query->bindParam(":hash", $hash);

        // execute query
        $status = $query->execute();
        
        // return insert status
        if ($status)
            return true;
        else
            return false;
    }
?>
