<?php

include 'connect.php';

    $tpl      = 'includes/templetes/';              //Route for templete directory
    $lang     = 'includes/languages/';              // lang directory
    $func     = 'includes/functions/';              // function directory
    $css      = 'layout/css/';                      //Route for css directory
    $js       = 'layout/js/';                       //Route for js directory


/**
 * Include imprortant files
 */
    include $func . 'function.php';
    include $lang . 'en.php';
    include $tpl . "header.php";
    /**
     * include navbar in all pages expect the one noNavbar variable
     */
    if(!isset($noNavbar))
    {
        include $tpl . "navbar.php";
    }

