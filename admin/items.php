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
        echo 'Welcome to items page';
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
            $name     = $_POST['name'];
            $des      = $_POST['des'];
            $price    = $_POST['price'];
            $country  = $_POST['country'];
            $status   = $_POST['status'];
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
                                                    items(Name, Des, Price, Add_Date , Country_Made , Status )
                                                    VALUES(:zname , :zdes , :zprice , now() , :zcountry , :zstatus)");
                        $stmt->execute(array(
                            'zname'     => $name,
                            'zdes'      => $des,
                            'zprice'    => $price,
                            'zcountry'  => $country,
                            'zstatus'   => $status,
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

    }
    elseif($do == 'Update')
    {

    }
    elseif($do == 'Delete')
    {

    }
    elseif($do == 'Approve')
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
