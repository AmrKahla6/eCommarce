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
       echo 'Welcome to manage member page'.'<br>';
       echo '<a href="?do=Add">Add New Member</a>';
   }
   // Add Members Page
   elseif($do == 'Add')
   { ?>
       <h1 class="text-center">Add New Members</h1>
       <div class="container">
           <form class="form-horizontal" action="?do=Store" method="POST">
               <!-- Start UserName Faild -->
               <div class="form-group form-group-lg">
                   <label class="col-sm-2 control-label">Username</label>
                   <div class="col-sm-10 col-md-6">
                       <input type="text" name="username" class="form-control" placeholder="ADD USERNAME" autocomplete="off" required>
                   </div>
               </div>
               <!-- End UserName Faild -->

               <!-- Start Password Faild -->
               <div class="form-group form-group-lg">
                   <label class="col-sm-2 control-label">Password</label>
                   <div class="col-sm-10 col-md-6">
                       <input type="password" name="password" class="password form-control" autocomplete="new-password" placeholder="ADD PASSWORD" required>
                       <i class="show-pass fa fa-eye fa-2x"></i>
                   </div>
               </div>
               <!-- End Password Faild -->

               <!-- Start FullName Faild -->
               <div class="form-group form-group-lg">
                       <label class="col-sm-2 control-label">Full Name</label>
                       <div class="col-sm-10 col-md-6">
                           <input type="text" name="full" class="form-control" placeholder="ADD FULL NAME" autocomplete="off" required>
                       </div>
                   </div>
                   <!-- End FullName Faild -->

                   <!-- Start Email Faild -->
                   <div class="form-group form-group-lg">
                       <label class="col-sm-2 control-label">Email</label>
                       <div class="col-sm-10 col-md-6">
                           <input type="email" name="email" class="form-control" placeholder="ADD EMAIL" autocomplete="off" required>
                       </div>
                   </div>
               <!-- End Email Faild -->

               <!-- Start submit Faild -->
                   <div class="form-group form-group-lg">
                       <div class="col-sm-offset-2 col-sm-10">
                           <input type="submit" value="ADD" class="btn btn-primary btn-lg">
                       </div>
                   </div>
               <!-- End submit Faild -->
           </form>
       </div>
       <?php
   }

    elseif($do == 'Store')
    {
        // Stror member to db
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            echo '<h1 class="text-center">Store Members</h1>';
            echo "<div class='container'>";
            // Get varabiles from form
            $user     = $_POST['username'];
            $pass     = $_POST['password'];
            $email    = $_POST['email'];
            $name     = $_POST['full'];
            $hashpass = sha1($pass);
             //Validate the form
             $formerrors = array();
           //   if(strlen($user <div 4))
           //   {
           //     $formerrors[] = 'Username can not be less than 4 charachter';
           //   }

             if(empty($user))
             {
                $formerrors[] = 'Username can not be <strong> null </strong>';
             }
             if(empty($pass))
             {
                $formerrors[] = 'Password can not be <strong> null </strong>';
             }
             if(empty($email))
             {
                $formerrors[] = 'Email can not be <strong> null </strong>';
             }
             if(empty($name))
             {
                $formerrors[] = 'Full name can not be <strong> null </strong>';
             }

             // Loop into Errors and echo it
             foreach($formerrors as $error)
             {
                 echo '<div class="alert alert-danger">' .$error . '</div>';
             }
             // Chech if no errors
             if(empty($formerrors))
             {
                 // Store members in db
                $stmt = $con->prepare("INSERT INTO
                                            users(Username, Password, Email, FullName )
                                            VALUES(:zuser , :zpass , :zemail , :zname)");
                $stmt->execute(array(
                    'zuser'  => $user,
                    'zpass'  => $hashpass,
                    'zemail' => $email,
                    'zname'  => $name,
                ));

                 // Ecoh success message
                 echo "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Store </div>';
             }
        }
        else
        {
            echo 'You can not browes this page directly';
        }
        echo "</div>";
    }

   elseif($do == 'Edit')
   {
        // Validate chech if Get request userid & is numeric
        $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0 ;

        // Select all data from db depend on this id
        $stmt  = $con->prepare("SELECT * FROM users where UserID = ? LIMIT 1");

        // Execute Query
        $stmt->execute(array($userid));

        // Fetch data from db
        $row   = $stmt->fetch();

       //if count > 0 this mean the db contain record about this username
        $count = $stmt->rowCount(); // exist or not
        if($count > 0){// Edit Page?>
            <h1 class="text-center">Edit Members</h1>
            <div class="container">
                <form class="form-horizontal" action="?do=Update" method="POST">
                <input type="hidden" name="userid" value="<?php echo $userid ?>">
                    <!-- Start UserName Faild -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Username</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="text" name="username" class="form-control" value="<?php echo $row['Username'] ?>" autocomplete="off" required>
                        </div>
                    </div>
                    <!-- End UserName Faild -->

                    <!-- Start Password Faild -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Password</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="hidden" name="old-password" value="<?php echo $row['Password'] ?>">
                            <input type="password" name="new-password" class="form-control" autocomplete="new-password" placeholder="Leave Blank If You Do Not Want To Change ">
                        </div>
                    </div>
                    <!-- End Password Faild -->

                    <!-- Start FullName Faild -->
                    <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Full Name</label>
                            <div class="col-sm-10 col-md-6">
                                <input type="text" name="full" class="form-control" value="<?php echo $row['FullName'] ?>" autocomplete="off" required>
                            </div>
                        </div>
                        <!-- End FullName Faild -->

                        <!-- Start Email Faild -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Email</label>
                            <div class="col-sm-10 col-md-6">
                                <input type="email" name="email" class="form-control" value="<?php echo $row['Email'] ?>" autocomplete="off" required>
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
       // If there is no sach ID  show error message
        }
        else
        {
            echo 'there is no such ID';
        }
   } elseif($do == 'Update')
   {// Update Page
     echo '<h1 class="text-center">Update Members</h1>';
     echo "<div class='container'>";
     if($_SERVER['REQUEST_METHOD'] == 'POST')
     {
         // Get varabiles from form
         $id    = $_POST['userid'];
         $user  = $_POST['username'];
         $email = $_POST['email'];
         $name  = $_POST['full'];

         // Update password
          $pass = empty($_POST['new-password']) ?  $_POST['old-password'] : sha1($_POST['new-password']);

          //Validate the form
          $formerrors = array();
        //   if(strlen($user <div 4))
        //   {
        //     $formerrors[] = 'Username can not be less than 4 charachter';
        //   }

          if(empty($user))
          {
             $formerrors[] = '<div class="alert alert-danger"> Username can not be <strong> null </strong> </div>';
          }
          if(empty($email))
          {
             $formerrors[] = '<div class="alert alert-danger"> Email can not be <strong> null </strong> </div>';
          }
          if(empty($name))
          {
             $formerrors[] = '<div class="alert alert-danger"> Full name can not be <strong> null </strong> </div>';
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

              $stmt = $con->prepare("UPDATE users SET Username = ? , Email = ? , FullName = ? , Password = ? WHERE UserID = ?");
              $stmt->execute(array($user , $email , $name , $pass , $id));

              // Ecoh success message
              echo "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Updated </div>';
          }
     }
     else
     {
         echo 'You can not browes this page directly';
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
