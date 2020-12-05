<?php

include 'admin/connect.php';

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
    include $tpl . "navbar.php";


