<?php
    session_start();
    if(isset($_SESSION['Username']))
    {
       echo 'Welcome' ." ". $_SESSION['Username'];
    }
    else
    {
        // echo 'You are not authorized to view this page';
        header('Location: index.php');
        exit();
    }
