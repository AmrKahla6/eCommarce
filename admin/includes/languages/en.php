<?php


   function lang($phrase)
   {

    static $lang = array(
       /**
        * Dashboaed Page
        */
        'HOME_ADMIN'  => 'Home',
        'CATEGORIES'  => 'Categories',
        'EDITPROFILE' => 'Edit profile',
        'SETTING'     => 'Setting',
        'LOGOUT'      => 'Logout',
    );
    return $lang[$phrase];
   }
