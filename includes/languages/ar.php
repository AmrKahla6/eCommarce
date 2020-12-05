<?php


   function lang($phrase)
   {

    static $lang = array(
        'MESSAGE' => 'مرحبا',
        'ADMIN'   => 'مدير الموقع',
    );
    return $lang[$phrase];
   }
