<?php

include 'connect.php';

  /**
   * Route for templete directory
   */
    $tpl = 'includes/templetes/';

   /**
   * Route for css directory
   */
       $css = 'layout/css/';

    /**
   * Route for js directory
   */
     $js = 'layout/js/';

     /**
      * Include the important files
    */
    $lang = 'includes/languages/'; // lang directory
    include $lang . 'en.php';
    include $tpl . "header.php";
    /**
     * include navbar in all pages expect the one noNavbar variable
     */
    if(!isset($noNavbar))
    {
        include $tpl . "navbar.php";
    }

