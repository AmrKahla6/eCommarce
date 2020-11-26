<?php
    session_start();

    if(isset($_SESSION['Username']))
    {
       $pageTitle = "Dashboard";
       include 'init.php';
       echo 'Welcome';
       include $tpl . "footer.php";
    }
    else
    {
        // echo 'You are not authorized to view this page';
        header('Location: index.php');
        exit();
    }
