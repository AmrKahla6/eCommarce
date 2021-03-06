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

       $cats = getAllFrom("*" , "categories" , "WHERE Parent = 0" , "" , "Ordering" , $sort)
       ?>

        <h1 class="text-center">Manage Categories</h1>
        <?php  if(!empty($cats)) {?>
        <div class="container categories">
             <div class="panel panel-default">
                   <div class="panel-heading">
                       <i class="fa fa-edit"></i> Main Categories
                       <div class="option pull-right">
                           <i class="fa fa-sort"></i> Ordering: [
                           <a class=" <?php if($sort == 'ASC')  { echo 'active' ; } ?> "  href="?sort=ASC">Asc</a> |
                           <a class=" <?php if($sort == 'DESC') { echo 'active' ; } ?> " href="?sort=DESC">Desc</a> ]

                           <i class="fa fa-eye"></i> View: [
                                <span class="active" data-view="full"> Full </span> |
                                <span data-view="classic"> Classic </span> ]
                       </div>
                   </div>

                   <div class="panel-body">
                <?php
                            foreach($cats as $cat)
                           {
                               echo "<div class='cat'>";
                                    echo "<div class='hidden-buttons'>";
                                          echo "<a href='?do=Edit&catid=". $cat['ID'] ."' class='btn btn-xs btn-primary'> <i class='fa fa-edit'> </i> Edit </a>";
                                          echo "<a href='?do=Delete&catid=". $cat['ID'] ."' class='confirm btn btn-xs btn-danger'> <i class='fa fa-close'> </i> Delete </a>";
                                    echo "</div>";

                                    echo "<h3>".$cat['Name'] . "</h3>";

                                    echo "<div class='full-view'>";

                                        echo "<p>"; if($cat['Des'] == ''){echo 'This is catgeory has no description';} else{echo $cat['Des'] ;} echo "</p>";

                                        if($cat['Visibilty'] == 1){ echo  "<span class='visibilty'> <i class='fa fa-eye'></i> Hidden</span>";}

                                        if($cat['Allow_Comment'] == 1){ echo  "<span class='commenting'> <i class='fa fa-close'></i> Comment Disabled</span>";}

                                        if($cat['Allow_Ads'] == 1){ echo  "<span class='advertises'> <i class='fa fa-close'></i> Ads Disabled</span>";}
                                             //Get Chiled Category
                                            $childCats = getAllFrom('*' , 'categories' , "WHERE Parent = {$cat['ID']}" , "" , 'Ordering' , 'ASC');
                                            if($childCats)
                                            {
                                                    echo "<h4 class='child-head'>Child Categies</h4>";
                                                    echo '<ul class="list-unstyled child-cats">';
                                                foreach($childCats as $child)
                                                {
                                                            echo  " <li class='child-link'>
                                                                         <a href='?do=Edit&catid=". $child['ID'] ."'>" . $child['Name'] . "</a>
                                                                         <a href='?do=Delete&catid=". $child['ID'] ."' class='show-delete confirm'> Delete </a>
                                                                    </li>" ;
                                                }
                                                        echo '</ul>';
                                            }
                                            else
                                            {
                                                    echo  '<h6 class="child-head"> No Child Category</h6>';
                                            }

                                    echo "</div>";
                               echo "</div>";



                               echo "<hr>";
                           }
                        ?>
                   </div>
             </div>
             <a class="btn btn-primary add-category" href="?do=Add"><i class="fa fa-plus"></i>Add New Category</a>
        </div>
       <?php
    }
       else
       {
            echo '<div class="container">';
                echo '<div class="nice-message">There\'s No Category To Show</div>';
                echo '<a class="btn btn-primary add-category" href="?do=Add"><i class="fa fa-plus"></i>Add New Category</a>';
            echo '</div>';
        }
    }
    elseif($do == 'Add')
    { ?>
        <h1 class="text-center"> Add New Category</h1>
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

                <!-- Start Perant Faild -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Perant ? </label>
                    <div class="col-sm-10 col-md-6">
                        <select name="parent" id="">
                            <option value="0">None</option> <!-- Main Category -->
                        <?php
                            $cats = getAllFrom("*" , "categories" , "WHERE Parent = 0" , "" , "Ordering");
                            foreach($cats as $cat)
                            {
                                echo "<option value='". $cat['ID'] ."'>" . $cat['Name'] . "</option>";
                            }
                        ?>
                        </select>
                    </div>
                </div>
                <!-- End Perant Faild -->

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
            $parent   = $_POST['parent'];
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
                                                categories(Name, Des, Parent, Ordering, Visibilty , Allow_Comment , Allow_Ads )
                                                VALUES(:zname , :zdes , :zparent , :zorder , :zvisible , :zcomment , :zads)");
                    $stmt->execute(array(
                        'zname'     => $name,
                        'zdes'      => $desc,
                        'zparent'   => $parent,
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
            redirectHome($theMsg);
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


                <!-- Start Perant Faild -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Perant ?</label>
                    <div class="col-sm-10 col-md-6">
                        <select name="parent" id=""?>"
                            <option value="0">None</option> <!-- Main Category -->
                        <?php
                            $cats = getAllFrom("*" , "categories" , "WHERE Parent = 0" , "" , "Ordering");
                            foreach($cats as $c)
                            {
                                echo "<option value='". $c['ID'] ."'";
                                if($cat['Parent'] == $c['ID']) {echo 'Selected';}
                                echo ">" . $c['Name'] . "</option>";
                            }
                        ?>
                        </select>
                    </div>
                </div>
                <!-- End Perant Faild -->

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
                            <input type="submit" value="Update Category" class="btn btn-primary btn-lg">
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
        echo '<h1 class="text-center">Update Category</h1>';
        echo "<div class='container'>";
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            // Get varabiles from form
            $id       = $_POST['catid'];
            $name     = $_POST['name'];
            $des      = $_POST['des'];
            $parent   = $_POST['parent'];
            $order    = $_POST['ordering'];
            $visible  = $_POST['visibilty'];
            $comment  = $_POST['commenting'];
            $ads      = $_POST['ads'];

            // Update db with info
            $stmt = $con->prepare("UPDATE
                                        categories
                                    SET
                                        Name          = ? ,
                                        Des           = ? ,
                                        Parent        = ? ,
                                        Ordering      = ? ,
                                        Visibilty     = ? ,
                                        Allow_Comment = ? ,
                                        Allow_Ads     = ?
                                    WHERE
                                        ID            = ?");
            $stmt->execute(array($name , $des , $parent , $order , $visible , $comment , $ads , $id));

            // Ecoh success message
            $theMsg =  "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Updated </div>';
            redirectHome($theMsg , 'back');
        }
        else
        {
            $theMsg = "<div class='alert alert-danger'> You can not browes this page directly </div>";
            redirectHome($theMsg);
        }
        echo "</div>";
    }
    elseif($do == 'Delete')
    {// Delete Category page
        echo '<h1 class="text-center"> Delete Category </h1>';
        echo "<div class='container'>";
            // Validate chech if Get request catid & is numeric
            $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0 ;

            // Select all data from db depend on this id
            $check = checkItem('ID' , 'categories' , $catid);

            if($check > 0){
                $stmt = $con->prepare("DELETE FROM categories WHERE ID = :zid");

                $stmt->bindParam(":zid" , $catid);
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
