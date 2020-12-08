<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo getTitle() ?></title>
        <link rel="stylesheet" href="<?php echo $css; ?>bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo $css; ?>font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo $css; ?>jquery-ui.css">
        <link rel="stylesheet" href="<?php echo $css; ?>jquery.selectBoxIt.css">
        <link rel="stylesheet" href="<?php echo $css; ?>frontend.css">
    </head>
    <body>
    <div class="upper-bar">
        <div class="container">
            <?php
                if(isset($_SESSION['user']))
                {?>
                    <img class="img-thumbnail img-circle my-img" src="default.png">
                    <div class="btn-group my-info">
                        <span class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                            <?php echo $sessionUser ?>
                            <span class="caret"></span>
                        </span>
                            <ul class="dropdown-menu">
                                <li>  <a href="profile.php"> My Profile </a> </li>
                                <li>  <a href="newAds.php"> New Item </a> </li>
                                <li>  <a href="profile.php#my-ads"> My Items </a> </li>
                                <li>  <a href="logout.php"> Logout </a> </li>
                            </ul>
                    </div>
                <?php
                    $status = checkUserStatus($sessionUser);

                    if($status == 1)
                    {
                        // echo 'Watting until activate your remembership';
                    }
                }else {
            ?>
             <a href="login.php">
                 <span class="pull-right">Login/Singup</span>
             </a>
        <?php } ?>
        </div>
    </div>
    <nav class="navbar navbar-inverse">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php">Home</a>
    </div>
    <div class="collapse navbar-collapse" id="app-nav">
      <ul class="nav navbar-nav navbar-right">
          <?php
               $cats = getAllFrom('*' , 'categories' , 'WHERE Parent = 0' , NULL , 'Ordering' , 'ASC');
               foreach($cats as $cat)
               {
                   echo '<li>
                             <a href="categories.php?catid='. $cat['ID'] .'&pagename='. str_replace(' ' , '-', $cat['Name']) .'">
                                  '. $cat['Name'] .'
                             </a>
                             </li>';
               }
          ?>
      </ul>
    </div>
  </div>
</nav>

        <div class="header">
            <!-- This is header -->
        </div>
