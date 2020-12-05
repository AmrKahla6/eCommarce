<?php


 /**
  * Get  category Function
  * Function To Get category From DB
 */

function getCategory()
{
    global $con;

    $getCat = $con->prepare("SELECT * FROM categories ORDER BY Ordering ASC");

    $getCat->execute();

    $cats   = $getCat->fetchAll();

    return $cats;
}

 /**
  * Get  Items Function
  * Function To Get Items From DB
 */

function getItem($catid)
{
    global $con;

    $getItem = $con->prepare("SELECT * FROM items WHERE Cat_ID = ?  ORDER BY item_ID DESC");

    $getItem->execute(array($catid));

    $items   = $getItem->fetchAll();

    return $items;
}

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

 function countItems($item , $table , $GroupID = null)
 {
    global $con ;

    $stmt2     = $con->prepare("SELECT COUNT($item) FROM $table $GroupID");
    $stmt2->execute();
    return $stmt2->fetchColumn();
 }


 /**
  * Get Latest Record Function
  * Function To Get latest Items From DB [Users , Items , Comments]
  * $select = Field to select
  * $table  = the table to choose from
  * $order  = The DESC ordering
  * $limit  = Number of recordes to get
 */

 function getLatest($select , $table, $GroupID = null , $order ,  $limit = 3 )
 {
     global $con;

     $getStmt = $con->prepare("SELECT $select FROM $table $GroupID ORDER BY $order DESC LIMIT $limit");

     $getStmt->execute();

     $rows   = $getStmt->fetchAll();

     return $rows;
 }




