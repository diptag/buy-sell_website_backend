<?php
    //enable session
    session_start();
    
    //requirements
    require("helpers.php");
    require(__DIR__."/../models/db.php");
    
    // require authetication for all pages except the pages in the array
    if (empty($_SESSION["id"]))
    {
        if (in_array($_GET["url"], array("sell", "profile", "change_password", "logout")))
        {
            // store msg to be displayed in $_SESSION
            $_SESSION["login_msg"] = "You need to login first.";
            $_SESSION["redirecting_page"] = $_GET["url"];
            redirect("/login");
        }
    }
?>
