<?php

ob_start();

session_start();

$pageTitle = "Items";

if(isset($_SESSION['Username']))
{
    include 'init.php';

    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage' ;

    if($do == 'Manage')
    {
        $stmt = $con->prepare(" SELECT
                                     items. * , categories.Name AS categories_name , users.Username AS User_name
                                FROM
                                    items
                                INNER JOIN
                                    categories
                                ON
                                    categories.ID = items.Cat_ID
                                INNER JOIN
                                   users
                                ON
                                  users.UserID = items.User_ID
                                ORDER BY
                                  item_ID DESC");
        $stmt->execute();

        // Assign to a variable
        $items = $stmt->fetchAll()
        ?>
         <!-- Manage Page -->
     <h1 class="text-center">Manage Item</h1>
     <?php  if(!empty($items)) { ?>
        <div class="container">
         <div class="table-responsive">
              <table class="main-table text-center table table-bordered">
                  <tr>
                      <td>#ID</td>
                      <td>Name</td>
                      <td>Description</td>
                      <td>Price</td>
                      <td>Adding Date</td>
                      <td>Category</td>
                      <td>User Name</td>
                      <td>Control</td>
                  </tr>
            <?php
                foreach($items as $item)
                       {
                           echo '<tr>';
                               echo '<td>'.$item['item_ID'] . '</td>';
                               echo '<td>'.$item['Name']. '</td>';
                               echo '<td>'.$item['Des']. '</td>';
                               echo '<td>'.$item['Price']. '</td>';
                               echo '<td>'.$item['Add_Date']. '</td>';
                               echo '<td>'.$item['categories_name']. '</td>';
                               echo '<td>'.$item['User_name']. '</td>';
                               echo "<td>
                                         <a href='items.php?do=Edit&itemid=" . $item['item_ID'] . "' class='btn btn-success'> <i class='fa fa-edit'></i> Edit</a>
                                         <a href='items.php?do=Delete&itemid=" . $item['item_ID'] . "' class='btn btn-danger confirm'> <i class='fa fa-close'></i>  Delete</a>";
                                         if($item['Approve'] == 0)
                                         {
                                             echo "<a href='items.php?do=Approve&itemid=" . $item['item_ID'] . "' class='btn btn-info activate'> <i class='fa fa-check'></i>  Approve </a>";
                                         }

                               echo  "</td>";
                           echo '</tr>';
                       }
                  ?>
              </table>
         </div>
             <a href="?do=Add" class="btn btn-primary btn-sm"> <i class="fa fa-plus"></i> New Item</a>
        </div>
<?php

    }
        else
        {
                echo '<div class="container">';
                    echo '<div class="nice-message">There\'s No Items To Show</div>';
                    echo '<a href="?do=Add" class="btn btn-primary btn-lg"> <i class="fa fa-plus"></i> New Item </a>';
                echo '</div>';
        }
    }
    elseif($do == 'Add')
    { ?>
        <h1 class="text-center"> Add New Item</h1>
        <div class="container">
            <form class="form-horizontal" action="?do=Store" method="POST">
                <!-- Start Name Faild -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="name" class="form-control" placeholder="Item Name" required>
                    </div>
                </div>
                <!-- End Name Faild -->

                <!-- Start Description Faild -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Description</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="des" class="form-control" placeholder="Add Description" required>
                    </div>
                </div>
                <!-- End Description Faild -->

                <!-- Start Price Faild -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Price</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="price" class="form-control" placeholder="Add Price to Item" required>
                    </div>
                </div>
                <!-- End Price Faild -->

                <!-- Start Country_Made Faild -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Country</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="country" class="form-control" placeholder="Add Country Made From" required>
                    </div>
                </div>
                <!-- End Country_Made Faild -->

                <!-- Start Status Faild -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Status</label>
                    <div class="col-sm-10 col-md-6">
                        <select name="status">
                               <option value="0">Choose Status</option>
                               <option value="1"> New      </option>
                               <option value="2"> Like New </option>
                               <option value="3"> Used     </option>
                               <option value="4"> Very Old </option>
                        </select>
                    </div>
                </div>
                <!-- End Status Faild -->

                  <!-- Start Users Faild -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Member</label>
                    <div class="col-sm-10 col-md-6">
                        <select name="member">
                               <option value="0">Choose Member</option>
                               <?php
                                    $users = getAllFrom("*", "users" , NULL , null , "UserID");

                                    foreach($users as $user)
                                    {
                                        echo "<option value='" . $user['UserID'] . "'>" . $user['Username'] . "</option>";
                                    }
                                ?>
                        </select>
                    </div>
                </div>
                <!-- End Users Faild -->

                  <!-- Start Category Faild -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Category</label>
                    <div class="col-sm-10 col-md-6">
                        <select name="category">
                               <option value="0">Choose Category</option>
                               <?php
                                    $categories = getAllFrom("*" , "categories" , "WHERE Parent != 0" , "" , "Ordering");

                                    foreach($categories as $category)
                                    {
                                        echo "<option value='" . $category['ID'] . "'>" . $category['Name'] . "</option>";
                                    }
                                ?>
                        </select>
                    </div>
                </div>
                <!-- End Category Faild -->

                 <!-- Start Tags Faild -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Tags</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="tag" class="form-control" placeholder="Separate Tags With Comma (,)">
                    </div>
                </div>
                <!-- End Tags Faild -->

                  <!-- Start submit Faild -->
                <div class="form-group form-group-lg">
                    <div class="col-sm-offset-2 col-sm-10">
                        <input type="submit" value="Add Item" class="btn btn-primary btn-sm">
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
            echo '<h1 class="text-center">Store Items</h1>';
            echo "<div class='container'>";
            // Get varabiles from form
            $name       = $_POST['name'];
            $des        = $_POST['des'];
            $price      = $_POST['price'];
            $country    = $_POST['country'];
            $status     = $_POST['status'];
            $member     = $_POST['member'];
            $cat        = $_POST['category'];
            $tag        = $_POST['tag'];
             //Validate the form
             $formerrors = array();


             if(empty($name))
             {
                $formerrors[] = 'Name Can\'t be <strong> Empty </strong>';
             }
             if(empty($des))
             {
                $formerrors[] = 'Description Can\'t be <strong> Empty </strong>';
             }
             if(empty($price))
             {
                $formerrors[] = 'Price Can\'t be <strong> Empty </strong>';
             }
             if(empty($country))
             {
                $formerrors[] = 'Country Can\'t be <strong> Empty </strong>';
             }

             if($status == 0)
             {
                $formerrors[] = 'Status Can\'t be <strong> Empty </strong>';
             }

             if($member == 0)
             {
                $formerrors[] = 'Member Can\'t be <strong> Empty </strong>';
             }

             if($cat == 0)
             {
                $formerrors[] = 'Category Can\'t be <strong> Empty </strong>';
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
                                                    items(Name, Des, Price, Add_Date , Country_Made , Status , User_ID , Cat_ID , Tag)
                                                    VALUES(:zname , :zdes , :zprice , now() , :zcountry , :zstatus , :zuser , :zcat , :ztag)");
                        $stmt->execute(array(
                            'zname'     => $name,
                            'zdes'      => $des,
                            'zprice'    => $price,
                            'zcountry'  => $country,
                            'zstatus'   => $status,
                            'zuser'     => $member,
                            'zcat'      => $cat,
                            'ztag'      => $tag
                        ));

                        // Ecoh success message
                        $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Store </div>';
                        redirectHome($theMsg , 'back');

            }
        }
        else
        {
            echo '<div class="container">';
            $theMsg = '<div class="alert alert-danger">  Sorry You Can Not Bitemes This Page Directly </div>';
            redirectHome($theMsg);
            echo '</div>';
        }
        echo "</div>";
    }
    elseif($do == 'Edit')
    {
        // Validate chech if Get request userid & is numeric
        $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0 ;

        // Select all data from db depend on this id
        $stmt  = $con->prepare("SELECT * FROM items where item_ID = ?");

        // Execute Query
        $stmt->execute(array($itemid));

        // Fetch data from db
        $item   = $stmt->fetch();

       //if count > 0 this mean the db contain record about this username
        $count = $stmt->rowCount(); // exist or not
        if($count > 0){// Edit Page?>
            <h1 class="text-center">Edit Item</h1>
            <div class="container">
                <form class="form-horizontal" action="?do=Update" method="POST">
                <input type="hidden" name="itemid" value="<?php echo $itemid ?>">
                    <!-- Start Name Faild -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="text" name="name" class="form-control" value="<?php echo $item['Name'] ?>" required>
                        </div>
                    </div>
                    <!-- End Name Faild -->

                    <!-- Start Description Faild -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Description</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="text" name="des" class="form-control" value="<?php echo $item['Des'] ?>">
                        </div>
                    </div>
                    <!-- End Description Faild -->

                     <!-- Start Price Faild -->
                     <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Price</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="text" name="price" class="form-control" value="<?php echo $item['Price'] ?>">
                        </div>
                    </div>
                    <!-- End Price Faild -->

                    <!-- Start Country Made Faild -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Country</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="text" name="country" class="form-control" value="<?php echo $item['Country_Made'] ?>">
                        </div>
                    </div>
                    <!-- End Country Made Faild -->

                      <!-- Start Status Faild -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Status</label>
                    <div class="col-sm-10 col-md-6" >
                        <select name="status" >
                               <option value="0">Choose Status</option>
                               <option value="1" <?php if($item['Status'] == 1) { echo 'selected' ;} ?>> New      </option>
                               <option value="2" <?php if($item['Status'] == 2) { echo 'selected' ;} ?>> Like New </option>
                               <option value="3" <?php if($item['Status'] == 3) { echo 'selected' ;} ?>> Used     </option>
                               <option value="4" <?php if($item['Status'] == 4) { echo 'selected' ;} ?>> Very Old </option>
                        </select>
                    </div>
                </div>
                <!-- End Status Faild -->

                <!-- Start Users Faild -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Member</label>
                    <div class="col-sm-10 col-md-6">
                        <select name="member">
                               <option value="0">Choose Member</option>
                               <?php
                                    $stmt = $con->prepare("SELECT * FROM users");
                                    $stmt->execute();
                                    $users = $stmt->fetchAll();

                                    foreach($users as $user)
                                    {
                                        echo "<option value='" . $user['UserID'] . "'";
                                        if($item['User_ID'] == $user['UserID'] ) { echo 'selected' ;}
                                        echo">" . $user['Username'] . "</option>";
                                    }
                                ?>
                        </select>
                    </div>
                </div>
                <!-- End Users Faild -->

                  <!-- Start Category Faild -->
                 <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Category</label>
                    <div class="col-sm-10 col-md-6">
                        <select name="category">
                               <option value="0">Choose Category</option>
                               <?php
                                    $categories = getAllFrom("*" , "categories" , "WHERE Parent != 0" , "" , "Ordering" );
                                    foreach($categories as $category)
                                    {
                                        echo "<option value='" . $category['ID'] . "'";
                                        if($item['Cat_ID'] == $category['ID'] ) { echo 'selected' ;}
                                        echo">" . $category['Name'] . "</option>";
                                    }
                                ?>
                        </select>
                    </div>
                 </div>
                <!-- End Category Faild -->

                  <!-- Start Tags Faild -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Tags</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="tag" class="form-control" value="<?php echo $item['Tag'] ?>" placeholder="Separate Tags With Comma (,)">
                    </div>
                </div>
                <!-- End Tags Faild -->


                    <!-- Start submit Faild -->
                        <div class="form-group form-group-lg">
                            <div class="col-sm-offset-2 col-sm-10">
                                <input type="submit" value="Update" class="btn btn-primary btn-lg">
                            </div>
                        </div>
                    <!-- End submit Faild -->
                </form>
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
                                            item_id = ?");
                $stmt->execute(array($itemid));
                $comments = $stmt->fetchAll();

                if(!empty($comments))
                {
                   ?>
                    <h1 class="text-center">Manage [ <?php echo $item['Name'] ?> ] Comments</h1>
                    <div class="table-responsive">
                        <table class="main-table text-center table table-bordered">
                            <tr>
                                <td>Comment</td>
                                <td>User Name</td>
                                <td>Comment Date</td>
                                <td>Control</td>
                            </tr>
                            <?php foreach($comments as $comment)
                                {
                                    echo '<tr>';
                                        echo '<td>'.$comment['comment']. '</td>';
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
                }
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
    echo '<h1 class="text-center">Update Category</h1>';
    echo "<div class='container'>";
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        // Get varabiles from form
        $id       = $_POST['itemid'];
        $name     = $_POST['name'];
        $des      = $_POST['des'];
        $price    = $_POST['price'];
        $country  = $_POST['country'];
        $status   = $_POST['status'];
        $cat      = $_POST['category'];
        $member   = $_POST['member'];
        $tag      = $_POST['tag'];

         //Validate the form
         $formerrors = array();


         if(empty($name))
         {
            $formerrors[] = 'Name Can\'t be <strong> Empty </strong>';
         }
         if(empty($des))
         {
            $formerrors[] = 'Description Can\'t be <strong> Empty </strong>';
         }
         if(empty($price))
         {
            $formerrors[] = 'Price Can\'t be <strong> Empty </strong>';
         }
         if(empty($country))
         {
            $formerrors[] = 'Country Can\'t be <strong> Empty </strong>';
         }

         if($status == 0)
         {
            $formerrors[] = 'Status Can\'t be <strong> Empty </strong>';
         }

         if($member == 0)
         {
            $formerrors[] = 'Member Can\'t be <strong> Empty </strong>';
         }

         if($cat  == 0)
         {
            $formerrors[] = 'Category Can\'t be <strong> Empty </strong>';
         }

         // Loop into Errors and echo it
         foreach($formerrors as $error)
         {
             echo '<div class="alert alert-danger">' .$error . '</div>';
         }
         // Chech if no errors
         if(empty($formerrors))
         {
                  // Update db with info
                    $stmt = $con->prepare("UPDATE
                    items
                        SET
                            Name          = ? ,
                            Des           = ? ,
                            Price         = ? ,
                            Country_Made  = ? ,
                            Status        = ? ,
                            Cat_ID        = ? ,
                            User_ID       = ?,
                            Tag           = ?
                        WHERE
                            item_ID       = ?");
                    $stmt->execute(array($name , $des , $price , $country , $status , $cat , $member , $tag , $id));
                    // Ecoh success message
                    $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Store </div>';
                    redirectHome($theMsg , 'back');

        }

    else
    {
        echo '<div class="container">';
        $theMsg = '<div class="alert alert-danger">  Sorry You Can Not Bitemes This Page Directly </div>';
        redirectHome($theMsg);
        echo '</div>';
    }
    echo "</div>";
    }
    else
    {
        $theMsg = "<div class='alert alert-danger'> You can not browes this page directly </div>";
        redirectHome($theMsg);
    }
    echo "</div>";
   }
    elseif($do == 'Delete')
   {// Delete Item page
    echo '<h1 class="text-center">Delete Item</h1>';
    echo "<div class='container'>";
        // Validate chech if Get request userid & is numeric
        $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0 ;

        // Select all data from db depend on this id
        $check = checkItem('item_ID' , 'items' , $itemid);

        if($check > 0){
            $stmt = $con->prepare("DELETE FROM items WHERE item_ID = :zitem");

            $stmt->bindParam(":zitem" , $itemid);
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
    {// Approve items
        echo '<h1 class="text-center">Approve Members</h1>';
        echo "<div class='container'>";
            // Validate chech if Get request itemid & is numeric
            $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0 ;

            // Select all data from db depend on this id
            $check = checkItem('item_ID' , 'items' , $itemid);

            if($check > 0){
                $stmt = $con->prepare("UPDATE items SET Approve = 1 WHERE item_ID = ?");

                $stmt->execute(array($itemid));

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
