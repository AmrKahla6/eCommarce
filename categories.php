<?php
    session_start();
    $pageTitle = "Category";
    include 'init.php';
    $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0 ;
    $items = getAllFrom('*' , 'items' , "WHERE Cat_ID = {$catid}"  , "AND Approve = 1" , "item_ID");
    ?>


<div class="container">
    <h1 class="text-center"> Show Category Items </h1>
    <div class="row">
        <?php
    if(isset($_GET['catid']))
    {
            if(!empty($items))
            {
                foreach($items as $item)
                {
                    echo '<div class="col-sm-6 col-md-3">' ;
                          echo '<div class="thumbnail item-box">';
                                echo '<small class="price-tag">$'. $item['Price'] .'</small>';
                                echo '<img class="img-responsive" src="default.png" alt="" srcset="" width="200" height="300">';
                                echo '<div class="caption">';
                                     echo '<h3> <a href="items.php?itemid='. $item['item_ID'] .'">'. $item['Name'] .'</a></h3>';
                                     echo '<p>'. $item['Des'] .'</p>';
                                     echo '<div class="date">'. $item['Add_Date'] .'</div>';
                                echo '</div>';
                          echo '</div>';
                    echo '</div>';
                }
            }
            else
            {
                echo 'No Items';
            }
        }
        else
        {
            echo 'You Didnt Specify Page ID';
        }
        ?>
    </div>
</div>
<?php
include $tpl . "footer.php";
?>
