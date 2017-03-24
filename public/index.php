<?php
    // configuration
    require("../includes/config.php");

    // check which controller to use
    if (isset($_GET["url"]))
        $url = $_GET["url"];
    else
        $url = "main";

    // use the required controller
    require("../controllers/".$url.".php");
?>
