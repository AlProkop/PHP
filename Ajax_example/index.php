<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

// start session for using session variables
session_start();

// define autoloaders
spl_autoload_register(
        function ($class)
        {
            if (file_exists("Controllers/$class.php"))
            include "Controllers/$class.php";
        });
spl_autoload_register(
        function ($class)
        {
            if (file_exists("Classes/$class.php"))
            include "Classes/$class.php";
        });
spl_autoload_register(
        function ($class)
        {
            if (file_exists("Models/$class.php"))
            include "Models/$class.php";
        });

// create and call controller
$cont = new AjaxController();

// call view
include "Views/loginView.php";