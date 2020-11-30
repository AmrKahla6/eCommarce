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
  * $errorMsg = Echo the messgae [Error || success]
  * $seconds  = Secondes before redirect
  * $url      = The link you want to redirect to
  */

  function redirectHome($theMsg , $url = null , $seconds = 3)
  {
      if($url === null)
      {
          $url  = 'index.php';
          $link = 'Homepage' ;
      }
      else
      {
          if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== "")
          {
            $url  = $_SERVER['HTTP_REFERER'];
            $link = 'Previous Page' ;
          }
          else
          {
              $url = 'index.php';
              $link = 'Homepage' ;
          }
      }
      echo $theMsg;

      echo "<div class='alert alert-info'>You Will Be Redirect To $link after $seconds seconds.</div>";

      header("refresh:$seconds; url = $url");

      exit();
  }

  /**
   * Function ti check item in db [function accept parametars]
   * $select = the item to select [Example : users , item]
   * $from   = the table to select from [Example : users , item]
   * $value  = the value of select
  */

  function checkItem($select , $from , $value)
  {
      global $con ;

      $statment = $con->prepare("SELECT $select FROM $from WHERE $select = ?");
      $statment->execute(array($value));

      $count = $statment->rowCount();
      return $count;
  }

  /**
   * Count number of items functions
   * Function to count number of item rows
   * $item  = Item to count
   * $table = The table to choose from
 */

 function countItems($item , $table)
 {
    global $con ;

    $stmt2     = $con->prepare("SELECT COUNT($item) FROM $table");
    $stmt2->execute();
    return $stmt2->fetchColumn();
 }



