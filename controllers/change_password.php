<?php
    // if user reached the page via GET
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // render change password form
        render("change_password_form", ["title" => "Change Password"]);
    }

    // if user reached the page via POST
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // validate data
        if (empty($_POST["old"]) || empty($_POST["new"]) || empty($_POST["renew"]))
        {
            // render change password form with error msg
            render("change_password_form", ["title" => "Change Password", "error_msg" => "All Fields are Mandatory."]);
        }

        // Check if user has entered same new passsword twice or not
        if ($_POST["new"] !== $_POST["renew"])
        {
            render("change_password_form", ["title" => "Change Password", "error_msg" => "Type the same new password twice"]);
        }
        
        // get old password's hash for the database
        $hash = get_password();

        // check if old password typed by the user is same
        if (!password_verify($_POST["old"], $hash))
        {
            render("change_password_form", ["title" => "Change Password", "error_msg" => "Incorrect old password"]);
        }

        // update new passsword
        if (update_password($_POST["new"]))
        {
            // render success
            render ("msg", ["title" => "Change Password", "msg" => "Password Succesfully Changed"]);
        }
        else
        {
            // apologize 
            render ("msg", ["title" => "Change Password", "msg" => "Couldn't Changed Password. Some unexpected error occurred"]);
        }

    }

?>
