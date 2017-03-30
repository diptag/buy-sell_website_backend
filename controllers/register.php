<?php
    // get all the college names from the table colleges to display in drop-down list
    $colleges = get_colleges($dbh);

    // if user reached the page via GET (as by clicking a link or redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
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

        // check both passwords are same
        if ($_POST["password"] !== $_POST["password_2"])
        {
            render("register_form", ["title" => "Register", "colleges" => $colleges, "error_msg" => "Passwords do not match."]);
        }
        
        // check if email is already registered and register user
        if (register_usr($_POST["email"], $_POST["name"], $_POST["college"], $_POST["password"]))
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