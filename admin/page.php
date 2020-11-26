<?php
$do = isset($_GET['do']) ? $_GET['do'] : "Manage" ;

/**
 * If the main page
 */
if($do == 'Manage')
{
    echo 'Welcome you are in the manage category page';
    echo '<a href="?do=Add">Add new category +</a>';
}elseif($do == 'Add')
{
    echo "You are in add catgeory page";
}
elseif($do == 'Insert')
{
    echo "You are in insert catgeory page";
}
else {
    echo 'There is no page with this name';
}
