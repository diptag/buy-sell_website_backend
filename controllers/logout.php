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
    
    // redirect to store
    redirect("/");
?>