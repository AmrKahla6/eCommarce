<?php
    session_start();
    $pageTitle = $_GET['pagename']." Category";
    include 'init.php';
    $items = getItem('Cat_ID ' , $_GET['catid']);
 ?>


<div class="container">
    <h1 class="text-center"> <?php echo str_replace('-' , ' ' , $_GET['pagename']) ?> </h1>
    <div class="row">
        <?php
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
        ?>
    </div>
</div>
<?php
include $tpl . "footer.php";
?>
