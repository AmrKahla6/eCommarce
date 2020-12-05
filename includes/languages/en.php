<?php


   function lang($phrase)
   {

    static $lang = array(
       /**
        * Navbar links
        */
        'HOME_ADMIN'  => 'Home',
        'EDITPROFILE' => 'Edit profile',
        'SETTING'     => 'Settings',
        'LOGOUT'      => 'Logout',
        'CATEGORIES'  => 'Categories',
        'ITEMS'       => 'Item',
        'MEMBERS'     => 'Members',
        'COMMENTS'    => 'Comments',
        'STATISTICS'  => 'Statistics',
        'LOGS'        => 'Logo',

    );
    return $lang[$phrase];
   }
