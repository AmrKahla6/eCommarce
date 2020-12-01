<?php
    session_start();

    if(isset($_SESSION['Username']))
    {
       $pageTitle = "Dashboard";
       include 'init.php';
    /*Start Dashboard page*/

    ?>
    <div class="container home-stats text-center">
         <h1>Dashboard</h1>
         <div class="row">
              <div class="col-md-3">
                    <div class="stat st-members">
                         Total Members
                         <span> <a href="members.php"> <?php echo countItems('UserID' , 'users') ?> </a> </span>
                    </div>
              </div>

              <div class="col-md-3">
                    <div class="stat st-pending">
                         Panding Members
                         <span><a href="members.php?do=Manage&page=Pending">
                                   <?php echo  checkItem("RegStatus" , "users" , 0) ?>
                             </a></span>
                    </div>
              </div>

              <div class="col-md-3">
                    <div class="stat st-items">
                         Total Items
                         <span>200</span>
                    </div>
              </div>

              <div class="col-md-3">
                    <div class="stat st-comments">
                         Total Comments
                         <span>200</span>
                    </div>
              </div>
         </div>
    </div>


    <div class="container latest">
         <div class="row">
              <div class="col-sm-6">
                   <div class="panel panel-default">
                        <div class="panel-heading">
                           <i class="fa fa-users"></i>Latest Registerd Users
                        </div>
                        <div class="panel-body">
                             test
                        </div>
                   </div>
              </div>

              <div class="col-sm-6">
                   <div class="panel panel-default">
                        <div class="panel-heading">
                           <i class="fa fa-tag"></i>Latest Items
                        </div>
                        <div class="panel-body">
                             test
                        </div>
                   </div>
              </div>
         </div>
    </div>
    <?php
    /*End Dashboard page*/
       include $tpl . "footer.php";
    }
    else
    {
        // echo 'You are not authorized to view this page';
        header('Location: index.php');
        exit();
    }
