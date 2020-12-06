<?php

session_start();

$pageTitle = "Profile";

include 'init.php';
?>

    <h1 class="text-center"> <?php echo ucfirst($_SESSION['user']) ?> Profile</h1>
    <div class="information block">
        <div class="container">
            <div class="panel panel-primary">
                <div class="panel-heading">My information</div>
                <div class="panel-body">
                    Name : Mostafa
                </div>
            </div>
        </div>
    </div>

    <div class="my-ads block">
        <div class="container">
            <div class="panel panel-primary">
                <div class="panel-heading">My Advertisements</div>
                <div class="panel-body">
                    Test Ads
                </div>
            </div>
        </div>
    </div>

    <div class="my-comments block">
        <div class="container">
            <div class="panel panel-primary">
                <div class="panel-heading">Latest Comments</div>
                <div class="panel-body">
                   Test Comments
                </div>
            </div>
        </div>
    </div>

<?php
include $tpl . "footer.php";