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
                        <input type="text" name="des" class="form-control" placeholder="Add Description">
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
                        <select name="status" id="">
                               <option value="0">Choose Status</option>
                               <option value="1"> New      </option>
                               <option value="2"> Like New </option>
                               <option value="3"> Used     </option>
                               <option value="4"> Very Old </option>
                        </select>
                    </div>
                </div>
                <!-- End Status Faild -->

                 <!-- Start Rating Faild -->
                 <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Rating</label>
                    <div class="col-sm-10 col-md-6">
                        <select name="rating" id="">
                               <option value="0">Choose Rating</option>
                               <option value="1"> *     </option>
                               <option value="2"> **    </option>
                               <option value="3"> ***   </option>
                               <option value="4"> ****  </option>
                               <option value="4"> ***** </option>
                        </select>
                    </div>
                </div>
                <!-- End Rating Faild -->

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
