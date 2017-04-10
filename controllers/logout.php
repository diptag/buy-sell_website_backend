<?php
    // unset any session variables
    $_SESSION = [];
    
    // expire cookie
    if (!empty($_COOKIE[session_name()]))
    {
        setcookie(session_name(), "", time() - 42000);
    }
    
    // destroy session
    session_destroy();
    
    // display logged out succesfully
    render("logout_view", ["title" => "Logged Out"]);
?>