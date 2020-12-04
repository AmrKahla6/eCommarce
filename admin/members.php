<?php
/**
 * Manage member page
 * You can Add | Edit | Delete members from here
 */
ob_start();
session_start();

if(isset($_SESSION['Username']))
{
   $pageTitle = "Members";
   include 'init.php';

   $do = isset($_GET['do']) ? $_GET['do'] : "Manage" ;

   // Start manage page
   if($do == 'Manage')
   {
       $query = '';

       if(isset($_GET['page']) && $_GET['page'] == 'Pending')
       {
           $query = 'AND RegStatus = 0';
       }
       // Select all members except Admins
       $stmt = $con->prepare("SELECT * FROM users where GroupID != 1 $query");
       $stmt->execute();

       // Assign to a variable
       $rows = $stmt->fetchAll()
       ?>
        <!-- Manage Page -->
    <h1 class="text-center">Manage Members</h1>
       <div class="container">
        <div class="table-responsive">
             <table class="main-table text-center table table-bordered">
                 <tr>
                     <td>#ID</td>
                     <td>Username</td>
                     <td>Fullname</td>
                     <td>Email</td>
                     <td>Registerd Date</td>
                     <td>Control</td>
                 </tr>
                <?php foreach($rows as $row)
                      {
                          echo '<tr>';
                              echo '<td>'.$row['UserID'] . '</td>';
                              echo '<td>'.$row['Username']. '</td>';
                              echo '<td>'.$row['FullName']. '</td>';
                              echo '<td>'.$row['Email']. '</td>';
                              echo '<td>'.$row['Date']. '</td>';
                              echo "<td>
                                        <a href='members.php?do=Edit&userid=" . $row['UserID'] . "' class='btn btn-success'> <i class='fa fa-edit'></i> Edit</a>
                                        <a href='members.php?do=Delete&userid=" . $row['UserID'] . "' class='btn btn-danger confirm'> <i class='fa fa-close'></i>  Delete</a>";

                                        if($row['RegStatus'] == 0)
                                        {
                                            echo "<a href='members.php?do=Activate&userid=" . $row['UserID'] . "' class='btn btn-info activate'> <i class='fa fa-check'></i>   Activate </a>";
                                        }
                              echo  "</td>";
                          echo '</tr>';
                      }
                 ?>
             </table>
        </div>
            <a href="?do=Add" class="btn btn-primary"> <i class="fa fa-plus"></i> New Member</a>
       </div>

   <?php
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
        // Store member to db
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
                 //Check if user exsist in db
                  $check = checkItem("Username" , "users" , $user);

                  if($check == 1)
                  {
                      $theMsg = '<div class="alert alert-danger"> Sorry this user is exsist </div>';
                      redirectHome($theMsg , 'back');
                  }
                  else
                  {

                        // Store members in db
                        $stmt = $con->prepare("INSERT INTO
                                                    users(Username, Password, Email, FullName , RegStatus , Date )
                                                    VALUES(:zuser , :zpass , :zemail , :zname , 1 , now())");
                        $stmt->execute(array(
                            'zuser'  => $user,
                            'zpass'  => $hashpass,
                            'zemail' => $email,
                            'zname'  => $name,
                        ));

                        // Ecoh success message
                        $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Store </div>';
                        redirectHome($theMsg , 'back');
                    }
            }
        }
        else
        {
            echo '<div class="container">';
            $theMsg = '<div class="alert alert-danger">  Sorry You Can Not Browes This Page Directly </div>';
            redirectHome($theMsg);
            echo '</div>';
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
            echo "<div class='container'>";
            $theMsg = '<div class="alert alert-danger"> There Is No Such ID </div>';
            redirectHome($theMsg);
            echo "</div>";
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
   }elseif($do == 'Delete')
   {// Delete members page
        echo '<h1 class="text-center">Delete Members</h1>';
        echo "<div class='container'>";
            // Validate chech if Get request userid & is numeric
            $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0 ;

            // Select all data from db depend on this id
            $check = checkItem('userid' , 'users' , $userid);

            if($check > 0){
                $stmt = $con->prepare("DELETE FROM users WHERE UserID = :zuser");

                $stmt->bindParam(":zuser" , $userid);
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
   elseif($do == 'Activate')
   {// Activ Members
    echo '<h1 class="text-center">Active Members</h1>';
    echo "<div class='container'>";
        // Validate chech if Get request userid & is numeric
        $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0 ;

        // Select all data from db depend on this id
        $check = checkItem('userid' , 'users' , $userid);

        if($check > 0){
            $stmt = $con->prepare("UPDATE users SET RegStatus = 1 WHERE UserID = ?");

            $stmt->execute(array($userid));

            // Ecoh success message
            $theMsg =  "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Activated </div>';
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
