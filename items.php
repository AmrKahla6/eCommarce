<?php
    ob_start();
    session_start();
    $pageTitle = "Show Items";
    include 'init.php';

      // Validate chech if Get request userid & is numeric
      $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0 ;

      // Select all data from db depend on this id
      $stmt  = $con->prepare("  SELECT
                                     items.* , categories.ID As catid , categories.Name AS category_name ,
                                     users.Username As username
                                FROM
                                     items
                                INNER JOIN
                                     categories
                                ON
                                     categories.ID = items.Cat_ID
                                INNER JOIN
                                     users
                                ON
                                     users.UserID  = items.User_ID
                                where
                                     item_ID = ?
                                AND
                                    Approve = 1");

      // Execute Query
      $stmt->execute(array($itemid));

      //if count > 0 this mean the db contain record about this username
      $count = $stmt->rowCount(); // exist or not
      if($count > 0)
      {
          // Fetch data from db
          $item   = $stmt->fetch();
?>
    <h1 class="text-center"> Show <?php echo $item['Name'] ?></h1>
    <div class="container">
         <div class="row">
              <div class="col-md-3">
                   <img class="img-responsive img-thumbnail center-block" src="default.png" id="img" width="200" height="300">
              </div>
              <div class="col-md-9 item-info">
                   <h2> <?php echo $item['Name']?> </h2>
                   <p>  <?php echo $item['Des'] ?> </p>
                   <ul class="list-unstyled">
                        <li>
                            <i class="fa fa-calendar fa-fw"></i>
                            <span>Added Date  </span>: <?php echo $item['Add_Date'] ?>
                        </li>
                        <li>
                            <i class="fa fa-money fa-fw"></i>
                            <span>Price</span>:  $<?php echo $item['Price'] ?>
                         </li>
                        <li>
                            <i class="fa fa-flag fa-fw"></i>
                            <span>Made From</span>: <?php echo $item['Country_Made'] ?>
                        </li>
                        <li>
                            <i class="fa fa-list fa-fw"></i>
                            <span>Category</span>:
                            <a href="categories.php?catid=<?php echo $item['catid'] ?>&pagename=<?php echo $item['category_name'] ?>">
                                 <?php echo $item['category_name'] ?>
                            </a>
                        </li>
                        <li>
                            <i class="fa fa-user fa-fw"></i>
                            <span>Added By</span>:
                            <a href="#">
                                <?php echo $item['username'] ?>
                            </a>
                        </li>
                   </ul>
              </div>
         </div>

         <hr class="custom-hr">
<?php
         if(isset($_SESSION['user']))
         {
?>
        <!-- Start Add Comment -->
         <div class="row">
             <div class="col-md-offset-3">
                 <div class="add-comment">
                    <h3>Add Your Comment</h3>
                    <form action="<?php echo $_SERVER['PHP_SELF'] . '?itemid='.$item['item_ID']?>" method="POST">
                        <textarea name="comment" id=""></textarea>
                        <input class="btn btn-primary" type="submit" value="Add Comment">
                    </form>
                    <?php
                       if($_SERVER['REQUEST_METHOD'] == 'POST')
                       {
                           $comment = filter_var($_POST['comment'] , FILTER_SANITIZE_STRING);
                           $itemid  = $item['item_ID'];
                           $userid  = $_SESSION['uid'];

                           if(!empty($comment))
                           {
                               $stmt = $con->prepare("INSERT INTO
                                                            comments(comment, status, comment_date, item_id, user_id)
                                                            VALUES(:zcomment, 0, now(), :zitemid, :zuserid)");
                                $stmt->execute(array(
                                    'zcomment' => $comment,
                                    'zitemid'  => $itemid,
                                    'zuserid'  => $userid
                                ));

                                if($stmt)
                                {
                                    echo '<div class="alert alert-success"> Comment Added Successfuly </div>';
                                }
                           }else
                           {
                               echo '<div> Add Comment </div>';
                           }
                       }
                    ?>
                 </div>
             </div>
         </div>
        <!-- End Add Comment -->
<?php  }
       else
       {
           echo '<div> <a href="login.php"> Login </a> Or <a href="login.php"> Register </a> To Add Comment </div>';
       }
?>
         <hr class="custom-hr">
         <?php
                    //Select all comments
                    $stmt = $con->prepare("SELECT
                                                comments.* , users.Username AS User_Name
                                            FROM
                                                comments
                                            INNER JOIN
                                                users
                                            ON
                                                users.UserID = comments.user_id
                                            WHERE
                                                item_id = ?
                                            AND
                                                status = 1
                                            ORDER BY
                                                comment_id DESC");


                $stmt->execute(array($item['item_ID']));
                $comments = $stmt->fetchAll();
                if($comments)
                {
                    foreach($comments as $comment)
                    {?>
                    <div class="comment-box">
                        <div class="row">
                            <div class="col-sm-2 text-center">
                                <img class="img-responsive img-thumbnail img-circle center-block" src="default.png" alt="" srcset="" width="200" height="300">
                                <?php echo $comment['User_Name'] ?>
                            </div>
                            <div class="col-sm-10">
                                <p class="lead"><?php echo $comment['comment']?></p>
                            </div>
                        </div>
                    </div>
                    <hr class="custom-hr">
                    <?php }
                }
                else
                {
                    echo 'No Comments';
                }
        ?>
    </div>
<?php
      }
      else
      {
          echo'<div class="container">';
                echo "<div class='alert alert-danger text-center'> This Item Is Not Exsist Or Item Watting To Approval </div>";
          echo'</div>';
      }
    include $tpl . "footer.php";
    ob_end_flush();

    ?>
