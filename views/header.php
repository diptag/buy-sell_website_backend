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
            ?>
        	        <div id="dropdown">
            	        <div id="dropdown-btn">Hi! <?= $_SESSION["name"] ?></div>
            	        <div id="dropdown-options">
                	        <a href="profile">My products</a>
                            <a href="change_password">Change Password</a>
                            <a href="logout">Log Out</a>
                        </div>
                    </div>
            <?php
                }
            ?>
        	<div class="nav-options"><a href="store">Go to Store</a></div>
            <div class="nav-options"><a href="sell">Sell a Product</a></div>
            <?php
                // check if user is logged in
                if (empty($_SESSION["id"]))
                {
            ?>
                    <div class="nav-options"><a href="login">Login</a> or <a href="register">Register</a></div>
            <?php
                }
            ?>
        </header>
        <div id="main">
