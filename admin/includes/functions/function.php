<?php

/**
 * Title Function
 */

 function getTitle()
 {
      global $pageTitle;
      if(isset($pageTitle))
      {
          echo $pageTitle;
      }else{
          echo 'Default';
      }
 }

 /**
  * Home Redirect function [This function Accept Parameters]
  * $errorMsg = Echo the error messgae
  * $seconds  = Secondes before redirect
  */

  function redirectHome($Msg , $seconds = 3)
  {
      echo "<div class='alert alert-success'>$Msg</div>";

      echo "<div class='alert alert-info'>You will redirect into homepage after $seconds seconds.</div>";

      header("refresh:$seconds; url = members.php");

      exit();
  }

   /**
  * error Redirect function [This function Accept Parameters]
  * $errorMsg = Echo the error messgae
  * $seconds  = Secondes before redirect
  */

  function redirecterror($errorMsg , $seconds = 3)
  {
      echo "<div class='alert alert-danger'>$errorMsg</div>";

      echo "<div class='alert alert-info'>You will redirect into homepage after $seconds seconds.</div>";

      header("refresh:$seconds; url = index.php");

      exit();
  }

