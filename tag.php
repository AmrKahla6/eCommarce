<?php
    session_start();
    $pageTitle = "Tags";
    include 'init.php';
    $tag     = isset($_GET['name']) ? intval($_GET['name']) : 0 ;
    ?>


<div class="container">
    <div class="row">
        <?php
    if(isset($_GET['name']))
    {
        $tag = $_GET['name'];
        echo '<h1 class="text-center">' . $_GET['name'] . '</h1>';
        $tagItems = getAllFrom('*' , 'items' , "WHERE Tag like '%$tag%'"  , "AND Approve = 1" , "item_ID");
            if(!empty($tagItems))
            {
                foreach($tagItems as $item)
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
                echo 'No Tags';
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
