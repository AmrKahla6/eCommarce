<?php

ob_start();

session_start();

$pageTitle = "Comments";

if(isset($_SESSION['Username']))
{
    include 'init.php';

    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage' ;

    if($do == 'Manage')
    {// Manage Comment Page

       //Select all comments
       $stmt = $con->prepare("SELECT
                                   comments.* , items.Name AS Item_Name , users.Username AS User_Name
                              FROM
                                   comments
                              INNER JOIN
                                   items
                              ON
                                   items.item_ID = comments.item_id
                              INNER JOIN
                                   users
                              ON
                                   users.UserID = comments.user_id
                              ORDER BY
                                   comment_id DESC");
       $stmt->execute();
       $comments = $stmt->fetchAll();
       ?>
        <h1 class="text-center">Manage Comments</h1>
        <?php if(!empty($comments)){ ?>
       <div class="container">
        <div class="table-responsive">
             <table class="main-table text-center table table-bordered">
                 <tr>
                     <td>#ID</td>
                     <td>Comment</td>
                     <td>Item Name</td>
                     <td>User Name</td>
                     <td>Comment Date</td>
                     <td>Control</td>
                 </tr>
                <?php
                    foreach($comments as $comment)
                        {
                            echo '<tr>';
                                echo '<td>'.$comment['comment_id'] . '</td>';
                                echo '<td>'.$comment['comment']. '</td>';
                                echo '<td>'.$comment['Item_Name']. '</td>';
                                echo '<td>'.$comment['User_Name']. '</td>';
                                echo '<td>'.$comment['comment_date']. '</td>';
                                echo "<td>
                                            <a href='comments.php?do=Edit&commentid=" . $comment['comment_id'] . "' class='btn btn-success'> <i class='fa fa-edit'></i> Edit</a>
                                            <a href='comments.php?do=Delete&commentid=" . $comment['comment_id'] . "' class='btn btn-danger confirm'> <i class='fa fa-close'></i>  Delete</a>";

                                            if($comment['status'] == 0)
                                            {
                                                echo "<a href='comments.php?do=Approve&commentid=" . $comment['comment_id'] . "' class='btn btn-info activate'> <i class='fa fa-check'></i> Approve </a>";
                                            }
                                echo  "</td>";
                            echo '</tr>';
                        }
                    ?>
                </table>

                <?php
        }else
        {
            echo '<div class="container">';
                echo '<div class="nice-message">There\'s No Comments Of Users To Show</div>';
            echo '</div>';
        }
    }
    elseif($do == 'Edit')
    {
        // Validate chech if Get request userid & is numeric
        $commid = isset($_GET['commentid']) && is_numeric($_GET['commentid']) ? intval($_GET['commentid']) : 0 ;

        // Select all data from db depend on this id
        $stmt  = $con->prepare("SELECT * FROM comments where comment_id = ?");

        // Execute Query
        $stmt->execute(array($commid));

        // Fetch data from db
        $comment   = $stmt->fetch();

       //if count > 0 this mean the db contain record about this username
        $count = $stmt->rowCount(); // exist or not
        if($count > 0){// Edit Page?>
            <h1 class="text-center">Edit Comments</h1>
            <div class="container">
                <form class="form-horizontal" action="?do=Update" method="POST">
                <input type="hidden" name="commentid" value="<?php echo $commid ?>">
                    <!-- Start Comment Faild -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Comment</label>
                        <div class="col-sm-10 col-md-6">
                            <textarea name="comment" id="" cols="20" rows="5" class="form-control" > <?php echo $comment['comment'] ?></textarea>
                        </div>
                    </div>
                    <!-- End Comment Faild -->

                    <!-- Start submit Faild -->
                <div class="form-group form-group-lg">
                    <div class="col-sm-offset-2 col-sm-10">
                        <input type="submit" value="Update" class="btn btn-primary btn-lg">
                    </div>
                </div>
                    <!-- End submit Faild -->
                </form>
            </div>
       <?php
       // If there is no sach ID  show error message
        }
        else
        {
            echo "<div class='container'>";
            $theMsg = '<div class="alert alert-danger"> There Is No Such ID </div>';
            redirectHome($theMsg);
            echo "</div>";
        }
   }
    elseif($do == 'Update')
     {// Update Page
        echo '<h1 class="text-center">Update Comments</h1>';
        echo "<div class='container'>";
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            // Get varabiles from form
            $id      = $_POST['commentid'];
            $comm    = $_POST['comment'];

             //Validate the form
             $formerrors = array();

             if(empty($comm))
             {
                $formerrors[] = '<div class="alert alert-danger"> Comment Body can not be <strong> null </strong> </div>';
             }

             // Loop into Errors and echo it
             foreach($formerrors as $error)
             {
                 echo $error;
             }
             // Chech if no errors
             if(empty($formerrors))
             {
                 // Update db with info

                 $stmt = $con->prepare("UPDATE comments SET comment = ? WHERE comment_id = ?");
                 $stmt->execute(array($comm , $id));

                 // Ecoh success message
                 $theMsg =  "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Updated </div>';
                 redirectHome($theMsg , 'back');
             }
        }
        else
        {
            $theMsg = "<div class='alert alert-danger'> You can not browes this page directly </div>";
            redirectHome($theMsg);
        }
        echo "</div>";
      }
    elseif($do == 'Delete')
    {// Delete Comments page
        echo '<h1 class="text-center">Delete Comments</h1>';
        echo "<div class='container'>";
            // Validate chech if Get request commentid & is numeric
            $commid = isset($_GET['commentid']) && is_numeric($_GET['commentid']) ? intval($_GET['commentid']) : 0 ;

            // Select all data from db depend on this id
            $check = checkItem('comment_id' , 'comments' , $commid);

            if($check > 0){
                $stmt = $con->prepare("DELETE FROM comments WHERE comment_id = :zcomment");

                $stmt->bindParam(":zcomment" , $commid);
                $stmt->execute();

                // Ecoh success message
                $theMsg =  "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Deleted </div>';
                redirectHome( $theMsg , 'back');
            }
            else
            {
                $theMsg =  "<div class='alert alert-danger'> This ID Is Not Exsist </div>";
                redirectHome($theMsg);
            }
         echo "</div>";
    }

    elseif($do == 'Approve')
    {// Approve Comments
     echo '<h1 class="text-center">Approve Comments</h1>';
     echo "<div class='container'>";
         // Validate chech if Get request userid & is numeric
         $commid = isset($_GET['commentid']) && is_numeric($_GET['commentid']) ? intval($_GET['commentid']) : 0 ;

         // Select all data from db depend on this id
         $check = checkItem('comment_id' , 'comments' , $commid);

         if($check > 0){
             $stmt = $con->prepare("UPDATE comments SET status = 1 WHERE comment_id = ?");

             $stmt->execute(array($commid));

             // Ecoh success message
             $theMsg =  "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Approved </div>';
             redirectHome( $theMsg , 'back');
         }
         else
         {
             $theMsg =  "<div class='alert alert-danger'> This ID Is Not Exsist </div>";
             redirectHome($theMsg);
         }
      echo "</div>";
    }
    include $tpl . "footer.php";
}
else
{
    // echo 'You are not authorized to view this page';
    header('Location: index.php');

    exit();
}

ob_end_flush();
?>

