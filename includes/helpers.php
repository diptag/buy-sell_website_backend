<?php
    /*
     * File containing helpful functions for the website
     */

    // render view passed as value
    function render ($view, $values = [])
    {
        // extract variables in local scope
        extract($values);

        // render views between header and footer
        require(__DIR__."/../views/header.php");
        require(__DIR__."/../views/".$view.".php");
        require(__DIR__."/../views/footer.php");
        exit;
    }
    
    // redirect to the page passed as argument
    function redirect ($location)
    {
        // send location header
        header("Location: {$location}");
        exit;
    }
?>