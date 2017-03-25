<?php

    // if user reached the page via GET (i.e. by clicking a linlk orredirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        render("login_form", ["title" => "Log In"]);
    } 
    
    // id the user reached the page via POST (i.e. by submitting a form)
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if (empty($_POST["email"]) || empty($_POST["password"]))
        {
            render("login_form", ["title" => "Log In", "error_msg" => "Invalid email or Password"]);
        }
        
        // query database for the user
        $user = get_usr($_POST["email"]);
        
        // if user doesn't exists in database
        if ($user["id"] !== null)
        {
            // check if password is correct
            if (password_verify($_POST["password"], $user["hash"]))
            {
                // remember that user is logged in by upadating user's id and namein session
                $_SESSION["id"] = $user["id"];
                $_SESSION["name"] = $user["name"];
                
                // redirect to main.php
                redirect("/");
            }
            else
            {
                render("login_form", ["title" => "Log In", "error_msg" => "Incorrect Password"]);
            }
        }
        // id user doesn't exists display error message
        else
        {
            render("login_form", ["title" => "Log In", "error_msg" => "User doesn't exists"]);
        }
    }
    
?>
