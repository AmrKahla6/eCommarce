<?php

session_start();

$pageTitle = "New Item";

include 'init.php';
if(isset($_SESSION['user']))
{
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $formErrors = array();

        $name       = filter_var($_POST['name'] , FILTER_SANITIZE_STRING);
        $des        = filter_var($_POST['des']  , FILTER_SANITIZE_STRING);
        $price      = filter_var($_POST['price'] , FILTER_SANITIZE_NUMBER_INT);
        $country    = filter_var($_POST['country'] , FILTER_SANITIZE_STRING);
        $status     = filter_var($_POST['status']  , FILTER_SANITIZE_NUMBER_INT);
        $cat        = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);

        if(strlen($name) < 4)
        {
            $formErrors[] = 'Item Title Must Be At Least 4 Characters';
        }

        if(strlen($des) < 10)
        {
            $formErrors[] = 'Item Description Must Be At Least 10 Characters';
        }

        if(strlen($country) < 2)
        {
            $formErrors[] = 'Item Country Must Be At Least 2 Characters';
        }

        if(empty($price))
        {
            $formErrors[] = 'Item Price Can\'t Be Empty';
        }

        if(empty($status))
        {
            $formErrors[] = 'Item Status Can\'t Be Empty';
        }

        if(empty($cat))
        {
            $formErrors[] = 'Item Category Can\'t Be Empty';
        }

    }
?>

    <h1 class="text-center">Create New Item</h1>
    <div class="create-ads block">
        <div class="container">
            <div class="panel panel-primary">
                <div class="panel-heading">Create New Item</div>
                <div class="panel-body">
                    <div class="row">
                         <div class="col-md-8">
                            <form class="form-horizontal main-form" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                                <!-- Start Name Faild -->
                                <div class="form-group form-group-lg">
                                    <label class="col-sm-3 control-label">Name</label>
                                    <div class="col-sm-10 col-md-9">
                                        <input type="text" name="name" class="form-control live-name" placeholder="Item Name" >
                                    </div>
                                </div>
                                <!-- End Name Faild -->

                                <!-- Start Description Faild -->
                                <div class="form-group form-group-lg">
                                    <label class="col-sm-3 control-label">Description</label>
                                    <div class="col-sm-10 col-md-9">
                                        <input type="text" name="des" class="form-control live-des" placeholder="Add Description" >
                                    </div>
                                </div>
                                <!-- End Description Faild -->

                                <!-- Start Price Faild -->
                                <div class="form-group form-group-lg">
                                    <label class="col-sm-3 control-label">Price</label>
                                    <div class="col-sm-10 col-md-9">
                                        <input type="text" name="price" class="form-control live-price" placeholder="Add Price to Item" >
                                    </div>
                                </div>
                                <!-- End Price Faild -->

                                <!-- Start Country_Made Faild -->
                                <div class="form-group form-group-lg">
                                    <label class="col-sm-3 control-label">Country</label>
                                    <div class="col-sm-10 col-md-9">
                                        <input type="text" name="country" class="form-control" placeholder="Add Country Made From" >
                                    </div>
                                </div>
                                <!-- End Country_Made Faild -->

                                <!-- Start Status Faild -->
                                <div class="form-group form-group-lg">
                                    <label class="col-sm-3 control-label">Status</label>
                                    <div class="col-sm-10 col-md-9">
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

                                <!-- Start Category Faild -->
                                <div class="form-group form-group-lg">
                                    <label class="col-sm-3 control-label">Category</label>
                                    <div class="col-sm-10 col-md-9">
                                        <select name="category">
                                            <option value="0">Choose Category</option>
                                            <?php
                                                    $stmt = $con->prepare("SELECT * FROM categories");
                                                    $stmt->execute();
                                                    $categories = $stmt->fetchAll();

                                                    foreach($categories as $category)
                                                    {
                                                        echo "<option value='" . $category['ID'] . "'>" . $category['Name'] . "</option>";
                                                    }
                                                ?>
                                        </select>
                                    </div>
                                </div>
                                <!-- End Category Faild -->

                                <!-- Start submit Faild -->
                                <div class="form-group form-group-lg">
                                    <div class="col-sm-offset-3 col-sm-9">
                                        <input type="submit" value="Add Item" class="btn btn-primary btn-sm">
                                    </div>
                                </div>
                                <!-- End submit Faild -->

                            </form>
                         </div>
                         <div class="col-md-4">
                            <div class="thumbnail item-box live-preview">
                                    <span class="price-tag">$</span>
                                    <img class="img-responsive" src="default.png" alt="" srcset="" width="200" height="300">
                                    <div class="caption">
                                       <h3>Title</h3>
                                        <p>Description</p>
                                     </div>
                            </div>
                         </div>
                    </div>
                         <!-- Start Looping Errors -->
                    <?php
                        if(!empty($formErrors))
                        {
                            foreach($formErrors as $error)
                            {
                                echo '<div class="alert alert-danger">'. $error . '</div>';
                            }
                        }
                    ?>
                    <!-- End Looping Errors -->
                </div>
            </div>
        </div>
    </div>

<?php
}
else
{
    header('Location: login.php');
    exit();
}
include $tpl . "footer.php"
?>
