<?php

ob_start();

session_start();

$pageTitle = "Categories";

if(isset($_SESSION['Username']))
{
    include 'init.php';

    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage' ;

    if($do == 'Manage')
    {
       $sort = "ASC";

       $sort_array = array('ASC' , 'DESC');

       if(isset($_GET['sort']) && in_array($_GET['sort'] , $sort_array))
       {
           $sort = $_GET['sort'];
       }

       $stmt2 = $con->prepare("SELECT * FROM categories ORDER BY Ordering $sort");

       $stmt2->execute();

       $cats = $stmt2->fetchAll(); ?>

        <h1 class="text-center">Manage Categories</h1>
        <div class="container categories">
             <div class="panel panel-default">
                   <div class="panel-heading">
                       Manage Categories
                       <div class="ordering pull-right">
                           Ordering :
                           <a class=" <?php if($sort == 'ASC')  { echo 'active' ; } ?> "  href="?sort=ASC">Asc</a> |
                           <a class=" <?php if($sort == 'DESC') { echo 'active' ; } ?> " href="?sort=DESC">Desc</a>
                       </div>
                   </div>

                   <div class="panel-body">
                        <?php
                           foreach($cats as $cat)
                           {
                               echo "<div class='cat'>";
                                    echo "<div class='hidden-buttons'>";
                                          echo "<a href='?do=Edit&catid=". $cat['ID'] ."' class='btn btn-xs btn-primary'> <i class='fa fa-edit'> </i> Edit </a>";
                                          echo "<a href='#' class='btn btn-xs btn-danger'> <i class='fa fa-close'> </i> Delete </a>";
                                    echo "</div>";

                                    echo "<h3>".$cat['Name'] . "</h3>";

                                    echo "<p>"; if($cat['Des'] == ''){echo 'This is catgeory has no description';} else{echo $cat['Des'] ;} echo "</p>";

                                    if($cat['Visibilty'] == 1){ echo  "<span class='visibilty'>Hidden</span>";}

                                    if($cat['Allow_Comment'] == 1){ echo  "<span class='commenting'>Comment Disabled</span>";}

                                    if($cat['Allow_Ads'] == 1){ echo  "<span class='advertises'>Ads Disabled</span>";}
                               echo "</div>";
                               echo "<hr>";
                           }
                        ?>
                   </div>
             </div>
        </div>
       <?php
    }
    elseif($do == 'Add')
    { ?>
        <h1 class="text-center">Add New Category</h1>
        <div class="container">
            <form class="form-horizontal" action="?do=Store" method="POST">
                <!-- Start Name Faild -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="name" class="form-control" placeholder="Category Name" autocomplete="off" required>
                    </div>
                </div>
                <!-- End Name Faild -->

                <!-- Start Description Faild -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Description</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="des" class="form-control" placeholder="Add Description">
                    </div>
                </div>
                <!-- End Description Faild -->

                <!-- Start Ordering Faild -->
                <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Ordering</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="text" name="ordering" class="form-control" placeholder="Number To Arrange The Category">
                        </div>
                    </div>
                    <!-- End Ordering Faild -->

                    <!-- Start Visibilty Faild -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Visible</label>
                        <div class="col-sm-10 col-md-6">
                            <div>
                                <input id="visible-yes"  type="radio" name="visibilty" value="0" checked>
                                <label for="visible-yes">Yes</label>
                            </div>

                            <div>
                                <input id="visible-no" type="radio" name="visibilty" value="1">
                                <label for="visible-no">No</label>
                            </div>
                        </div>
                    </div>
                <!-- End Visibilty Faild -->

                   <!-- Start Allow_Comment Faild -->
                   <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Allow Commenting</label>
                        <div class="col-sm-10 col-md-6">
                            <div>
                                <input id="com-yes"  type="radio" name="commenting" value="0" checked>
                                <label for="com-yes">Yes</label>
                            </div>

                            <div>
                                <input id="com-no" type="radio" name="commenting" value="1">
                                <label for="com-no">No</label>
                            </div>
                        </div>
                    </div>
                <!-- End Allow_Comment Faild -->

                   <!-- Start Allow_Ads Faild -->
                   <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Allow Ads</label>
                        <div class="col-sm-10 col-md-6">
                            <div>
                                <input id="ads-yes"  type="radio" name="ads" value="0" checked>
                                <label for="ads-yes">Yes</label>
                            </div>

                            <div>
                                <input id="ads-no" type="radio" name="ads" value="1">
                                <label for="ads-no">No</label>
                            </div>
                        </div>
                    </div>
                <!-- End Allow_Ads Faild -->

                <!-- Start submit Faild -->
                    <div class="form-group form-group-lg">
                        <div class="col-sm-offset-2 col-sm-10">
                            <input type="submit" value="Add Category" class="btn btn-primary btn-lg">
                        </div>
                    </div>
                <!-- End submit Faild -->
            </form>
        </div>
        <?php
    }
    elseif($do == 'Store')
    {
        // Store Category to db
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            echo '<h1 class="text-center">Store Category</h1>';
            echo "<div class='container'>";
            // Get varabiles from form
            $name     = $_POST['name'];
            $desc     = $_POST['des'];
            $order    = $_POST['ordering'];
            $visible  = $_POST['visibilty'];
            $comment  = $_POST['commenting'];
            $ads      = $_POST['ads'];


            //Check if Category exsist in db
            $check = checkItem("Name" , "categories" , $name);

            if($check == 1)
            {
                $theMsg = '<div class="alert alert-danger"> Sorry this Category is exsist </div>';
                redirectHome($theMsg , 'back');
            }
            else
            {

                    // Store Category in db
                    $stmt = $con->prepare("INSERT INTO
                                                categories(Name, Des, Ordering, Visibilty , Allow_Comment , Allow_Ads )
                                                VALUES(:zname , :zdes , :zorder , :zvisible , :zcomment , :zads)");
                    $stmt->execute(array(
                        'zname'     => $name,
                        'zdes'      => $desc,
                        'zorder'    => $order,
                        'zvisible'  => $visible,
                        'zcomment'  => $comment,
                        'zads'      => $ads,
                    ));

                    // Ecoh success message
                    $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Store </div>';
                    redirectHome($theMsg , 'back');
                }

        }
        else
        {
            echo '<div class="container">';
            $theMsg = '<div class="alert alert-danger">  Sorry You Can Not Browes This Page Directly </div>';
            redirectHome($theMsg , 'back');
            echo '</div>';
        }
        echo "</div>";
    }

    elseif($do == 'Edit')
    {
        // Validate chech if Get request CatID & is numeric
        $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0 ;

        // Select all data from db depend on this id
        $stmt  = $con->prepare("SELECT * FROM categories where ID = ?");

        // Execute Query
        $stmt->execute(array($catid));

        // Fetch data from db
        $cat   = $stmt->fetch();

       //if count > 0 this mean the db contain record about this username
        $count = $stmt->rowCount(); // exist or not
        if($count > 0){// Edit Category Page?>
               <h1 class="text-center">Edit Category</h1>
        <div class="container">
            <form class="form-horizontal" action="?do=Update" method="POST">
            <input type="hidden" name="catid" value="<?php echo $catid ?>">
                <!-- Start Name Faild -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="name" class="form-control" placeholder="Category Name" value="<?php echo $cat['Name']; ?>" required>
                    </div>
                </div>
                <!-- End Name Faild -->

                <!-- Start Description Faild -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Description</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="des" class="form-control" placeholder="Add Description" value="<?php echo $cat['Des']; ?>">
                    </div>
                </div>
                <!-- End Description Faild -->

                <!-- Start Ordering Faild -->
                <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Ordering</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="text" name="ordering" class="form-control" placeholder="Number To Arrange The Category" value="<?php echo $cat['Ordering']; ?>">
                        </div>
                    </div>
                    <!-- End Ordering Faild -->

                    <!-- Start Visibilty Faild -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Visible</label>
                        <div class="col-sm-10 col-md-6">
                            <div>
                                <input id="visible-yes"  type="radio" name="visibilty" value="0" <?php if($cat['Visibilty'] == 0){ echo 'checked'; } ?> >
                                <label for="visible-yes">Yes</label>
                            </div>

                            <div>
                                <input id="visible-no" type="radio" name="visibilty" value="1" <?php if($cat['Visibilty'] == 1){ echo 'checked'; } ?> >
                                <label for="visible-no">No</label>
                            </div>
                        </div>
                    </div>
                <!-- End Visibilty Faild -->

                   <!-- Start Allow_Comment Faild -->
                   <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Allow Commenting</label>
                        <div class="col-sm-10 col-md-6">
                            <div>
                                <input id="com-yes"  type="radio" name="commenting" value="0" <?php if($cat['Allow_Comment'] == 0){ echo 'checked'; } ?> >
                                <label for="com-yes">Yes</label>
                            </div>

                            <div>
                                <input id="com-no" type="radio" name="commenting" value="1" <?php if($cat['Allow_Comment'] == 1){ echo 'checked'; } ?> >
                                <label for="com-no">No</label>
                            </div>
                        </div>
                    </div>
                <!-- End Allow_Comment Faild -->

                   <!-- Start Allow_Ads Faild -->
                   <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Allow Ads</label>
                        <div class="col-sm-10 col-md-6">
                            <div>
                                <input id="ads-yes"  type="radio" name="ads" value="0" <?php if($cat['Allow_Ads'] == 0){ echo 'checked'; } ?> >
                                <label for="ads-yes">Yes</label>
                            </div>

                            <div>
                                <input id="ads-no" type="radio" name="ads" value="1" <?php if($cat['Allow_Ads'] == 1){ echo 'checked'; } ?> >
                                <label for="ads-no">No</label>
                            </div>
                        </div>
                    </div>
                <!-- End Allow_Ads Faild -->

                <!-- Start submit Faild -->
                    <div class="form-group form-group-lg">
                        <div class="col-sm-offset-2 col-sm-10">
                            <input type="submit" value="Add Category" class="btn btn-primary btn-lg">
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
