<?php
    session_start();

    if(isset($_SESSION['Username']))
    {
       $pageTitle = "Dashboard";
       include 'init.php';
    //    print_r($_SESSION);
          echo 'Welcom';
       include $tpl . "footer.php";
    }
    else
    {
        // echo 'You are not authorized to view this page';
        header('Location: index.php');
        exit();
    }
