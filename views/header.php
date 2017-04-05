<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="css/styles.css">
<title><?= $title ?></title>
</head>

<body>
    <div id="wrapper">
        <header>
            <?php 
                // check if user is logged in
                if (!empty($_SESSION["name"]))
                {
                    // if user is logged in show dropdown
            ?>
        	        <div id="dropdown">
            	        <div id="dropdown-btn">Hi! <?= $_SESSION["name"] ?></div>
            	        <div id="dropdown-options">
                	        <a href="dashboard">Dashboard</a>
                            <a href="change_password">Change Password</a>
                            <a href="logout">Log Out</a>
                        </div>
                    </div>
            <?php
                }
                else
                {
                    // else show login and register buttons
            ?>
                    <div id="login-register"><a href="login">Login</a> or <a href="register">Register</a></div>
            <?php
                }
            ?>
        	<div class="nav-options"><a href="store">Go to Store</a></div>
            <div class="nav-options"><a href="sell">Sell a Product</a></div>
        </header>
        <div id="main">