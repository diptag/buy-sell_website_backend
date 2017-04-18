project_2

This project implies the idea of buy - sell website for college students. Users can post ad for the products they want to sell just
by first registering themselves on the website. Buyers can then go through the products listed on the website and buy them by
contacting the seller by the contact information given on the website. Sellers can also choose to donate the products. Sellers also
have the option to change the price of the product of the products by going to the dashboard. After selling the product the sellers
have to mark the product 'as sold' so that it will not be shown again on the website. Sellers can also change the password of their
account any time they want.

The different files in the website are:
1)config.json - contains the credentials for the database and the databse name to be used.
2)project_2.sql - the file created by mysqldump of databse 'project_2'
3).htaccess - redirects all the requests to public folder
4)public
    a).htaccess - file for formatting the URL
    b)index.php - single entry point for the user, selects the controller to used based on the page requested
    c)img - directory contaiing the product images 
    d)css - directory containg the css files
    e)js - directory contaiing the jquery include file and javascript file for the website
5)includes
    a)config.php - file containg the initial commands like session_start etc. to be included in each file
    b)helpers.php - file contaiing some functions for use
6)models
    a)db.php - file which contains functions to query database for differnent purposes
7)controllers - directory containing different php files to be used depending on the request
8)views - directory containing the php files used to diplay the contents of a page

How to run the project on IDE
1)First check the database credentials used in config.php and change them if required.
2)Start the server using 'apache50 start ~/workspace/project_2' or 'apache50 start ~/workspace/project_2/public'
3)Start the mysql server using 'mysql50 start'
4)If the project is run on different user's IDE, first use 'username50' and 'password50' to get username and password of the user.
    The in a new tab go to https://ide50-{username}.cs50.io/phpmyadmin and use the username and password. After opening phpmyadmin 
    go to SQL tab paste the commands in 'project_2.sql' in it and click Go. This will setup the database for the project.
5)Now, just go to https://ide50-{username}.cs50.io to visit the website.