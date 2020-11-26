<?php
/**
 * Manage member page
 * You can Add | Edit | Delete members from here
 */

session_start();

if(isset($_SESSION['Username']))
{
   $pageTitle = "Members";
   include 'init.php';

   $do = isset($_GET['do']) ? $_GET['do'] : "Manage" ;

   // Start manage page
   if($do == 'Manage')
   {
       // Manage Page
   }elseif($do == 'Edit')
   {
       // Edit Page
       ?>
         <h1 class="text-center">Edit Members</h1>
         <div class="container">
             <form class="form-horizontal" action="" method="post">
                 <!-- Start UserName Faild -->
                 <div class="form-group form-group-lg">
                     <label class="col-sm-2 control-label">Username</label>
                     <div class="col-sm-10 col-md-6">
                         <input type="text" name="username" class="form-control" autocomplete="off">
                     </div>
                 </div>
                 <!-- End UserName Faild -->

                  <!-- Start Password Faild -->
                  <div class="form-group form-group-lg">
                     <label class="col-sm-2 control-label">Password</label>
                     <div class="col-sm-10 col-md-6">
                         <input type="password" name="password" class="form-control" autocomplete="new-password">
                     </div>
                 </div>
                 <!-- End Password Faild -->

                   <!-- Start FullName Faild -->
                   <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Full Name</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="text" name="full" class="form-control" autocomplete="off">
                        </div>
                     </div>
                    <!-- End FullName Faild -->

                     <!-- Start Email Faild -->
                     <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="email" name="email" class="form-control" autocomplete="off">
                        </div>
                     </div>
                 <!-- End Email Faild -->

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
   }
   include $tpl . "footer.php";
}
else
{
    // echo 'You are not authorized to view this page';
    header('Location: index.php');
    exit();
}
