<?php
//session_start(); // start session for using session variables

//error_reporting(E_ALL);
//ini_set('display_errors', 1);

// define autoloaders

spl_autoload_register(
        function ($class)
        {
            if (file_exists("Classes/$class.php"))
            include "Classes/$class.php";
        });
        
        
session_start(); // start session for using session variables after included Classes
                 // otherwise we can't store objects in $session 

spl_autoload_register(
        function ($class)
        {
            if (file_exists("Controllers/$class.php"))
            include "Controllers/$class.php";
        });
        
spl_autoload_register(
        function ($class)
        {
            if (file_exists("Models/$class.php"))
            include "Models/$class.php";
        });

// create and call controller
$cont = new MVCController();

// call view
//include "Views/loginView.php";