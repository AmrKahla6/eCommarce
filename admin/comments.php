<?php

ob_start();

session_start();

$pageTitle = "Comments";

if(isset($_SESSION['Username']))
{
    include 'init.php';

    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage' ;

    if($do == 'Manage')
    {
       // Manage Comment Page
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
                                   users.UserID = comments.user_id");
       $stmt->execute();
       $comments = $stmt->fetchAll();
       ?>
        <h1 class="text-center">Manage Comments</h1>
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
                <?php foreach($comments as $comment)
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
                                            echo "<a href='members.php?do=Approve&commentid=" . $comment['comment_id'] . "' class='btn btn-info activate'> <i class='fa fa-check'></i> Approve </a>";
                                        }
                              echo  "</td>";
                          echo '</tr>';
                      }
                 ?>
             </table>

   <?php
    }
    elseif($do == 'Edit')
    {

    }
    elseif($do == 'Update')
    {

    }
    elseif($do == 'Delete')
    {

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

