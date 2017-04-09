<?php
    // get all the college names from the table colleges to display in drop-down list
    $colleges = get_colleges($dbh);

    // if user reached the page via GET (as by clicking a link or redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // render register page
        render("register_form", ["title" => "Register", "colleges" => $colleges]);
    }

    // if user reached the page via POST (as by submitting form)
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // validate user input
        if (empty($_POST["name"]) || empty($_POST["email"]) || empty($_POST["college"]) || empty($_POST["password"]) || empty($_POST["password_2"]))
        {
            render("register_form", ["title" => "Register", "colleges" => $colleges, "error_msg" => "All fields are Mandatory"]);
        }
        
        // check if email id is valid
        if (!preg_match("/^.*@.*\..*$/", $_POST["email"]))
        {
            render("register_form", ["title" => "Register", "colleges" => $colleges, "error_msg" => "Invalid email id."]);
        }
        
        // check if name is of atleast 2 characters
        if (strlen($_POST["name"]) < 2)
        {
            render("register_form", ["title" => "Register", "colleges" => $colleges, "error_msg" => "Name should be of at least 2 characters."]);
        }

        // check both passwords are same
        if ($_POST["password"] !== $_POST["password_2"])
        {
            render("register_form", ["title" => "Register", "colleges" => $colleges, "error_msg" => "Passwords do not match."]);
        }
        
        // check if password is between 6 - 30 characters
        if (strlen($_POST["password"]) < 6 || strlen($_POST["password"]) > 30)
        {
            render("register_form", ["title" => "Register", "colleges" => $colleges, "error_msg" => "Password must be between 6 - 30 characters."]);
        }
        
        // check if email is already registered and register user
        if (register_usr($_POST))
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
            render("register_form", ["title" => "Register", "colleges" => $colleges, "error_msg" => "Email ID already registered."]);
        }
        
    }
?>