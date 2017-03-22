<?php
    // if user reached the page via GET (as by clicking a link or redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        render("register_form", ["title" => "Register"]);
    }

    // if user reached the page via POST (as by submitting form)
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // validate user input
        if (!isset($_POST["name"]) || !isset($_POST["email"]) || !isset($_POST["college"]) || !isset($_POST["password"]) || !isset($_POST["password_2"]))
        {
            render("register_form", ["title" => "Register", "error_msg" => "All fields are Mandatory"]);
        }

        // check both passwords are same
        if ($_POST["password"] !== $_POST["password_2"])
        {
            render("register", ["title" => "Register", "error_msg" => "Passwords do not match."]);
        }
        
        // check if email is already registered and register user
        if (register_usr($_POST["name"], $_POST["email"], $_POST["college"], $_POST["password"]))
        {
            // store user id and name in session variable
            $user = get_usr($_POST["email"]);
            $_SESSION["id"] = $user["id"];
            $_SESSION["name"] = $user["name"];
            
            // redirect user to main.php
            redirect("/");        
        }
        else
        {
            // render register_form and show error msg
            render("register_form", ["title" => "Register", "error_msg" => "Email ID already registered."]);
        }
        
    }
?>
