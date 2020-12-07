<?php
    ob_start();
    session_start();

    $pageTitle = "Login";

    if(isset($_SESSION['user']))
    {
        header('Location: index.php'); // redirect to home
    }
    include 'init.php';

    /**
     * Check if user comming from http request
     */
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        if(isset($_POST['login']))
        {
            $username   = $_POST['username'];
            $password   = $_POST['password'];
            $hashedPass = sha1($password);

            //Check if user exist in db
            $stmt  = $con->prepare("SELECT
                                        UserID , Username , Password
                                    FROM
                                        users
                                    where
                                        Username = ?
                                    AND
                                        Password = ?");
            $stmt->execute(array($username , $hashedPass));

            $get = $stmt->fetch();
            //if count > 0 this mean the db contain record about this username
            $count = $stmt->rowCount(); // exist or not
            if($count > 0)
            {
                $_SESSION['user'] = $username;
                // print_r($_SESSION['user']);
                $_SESSION['uid']  = $get['UserID']; // Regestier User ID

                header('Location: index.php');
                exit();
            }
        }
        else
        {
            $formErrors = array();

            $username = $_POST['username'];
            $password = $_POST['password'];
            $passConf = $_POST['password-confermation'];
            $email    = $_POST['email'];
            //Username Filter & Errors
            if(isset($username))
            {
                $filterUser = filter_var($username , FILTER_SANITIZE_STRING);
                if(strlen($filterUser) < 4)
                {
                    $formErrors[] = 'Username Must Be Larger Than 4 Characters';
                }
            }

            //Password Filter & Errors
            if(isset($password) && isset($passConf))
            {
                if(empty($password))
                {
                    $formErrors[] = 'Password Can\'t Be Null';
                }

                $pass1 =  sha1($password);
                $pass2 =  sha1($passConf);

                if($pass1 !== $pass2)
                {
                    $formErrors[] = 'Password Is\'t Match';
                }
            }


              //Email Filter & Errors
              if(isset($email))
              {
                  $filterEmail = filter_var($email, FILTER_SANITIZE_EMAIL);
                  if(filter_var($filterEmail , FILTER_VALIDATE_EMAIL) != true)
                  {
                      $formErrors[] = 'This Email Is Not Valid';
                  }
              }


             // Chech if no errors proceed the user add
             if(empty($formerrors))
             {
                 //Check if user exsist in db
                  $check = checkItem("Username" , "users" , $username);

                  if($check == 1)
                  {
                      $theMsg = '<div class="alert alert-danger"> Sorry this user is exsist </div>';
                      $formErrors[] = 'This User Is Exist';
                  }
                  else
                  {
                        // Store members in db
                        $stmt = $con->prepare("INSERT INTO
                                                    users(Username, Password, Email , RegStatus , Date )
                                                    VALUES(:zuser , :zpass , :zemail , 0 , now())");
                        $stmt->execute(array(
                            'zuser'  => $username,
                            'zpass'  => sha1($password),
                            'zemail' => $email
                        ));

                        // Ecoh success message
                        $successMsg = "Congrats You Are Now Registerd User";
                  }

            }
        }
    }

?>

    <div class="container login-page">
        <h1 class="text-center">
            <span class="selected" id="formButton" date-class="login">Login</span> | <span id="formButton2" date-class="signup">Signup</span>
        </h1>
        <!-- Start Form For Login -->
        <form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" id="form1">
            <input class="form-control"          type="text"     name="username" placeholder = "Enter Your Username" autocomplete="off">
            <input class="password form-control" type="password" name="password" placeholder = "Enter Your Password" autocomplete="new-password">
            <input class="btn-primary btn-block"  type="submit"  name="login"   value="Login">
            <i     class="show-pass fa fa-eye fa-2x"></i>
        </form>
        <!-- End Form For Login -->

        <!-- Start Form For Signup -->
        <form class="signup" action="" method="post" id="form2">
            <div class="input-container">
                <input pattern=".{4,}" title="Username must be 4 characters"
                       class="form-control" type="text" name="username"
                       placeholder = "Enter Username"  autocomplete="off" required>
            </div>

            <div class="input-container">
                <input minlength="4" class="form-control"
                       type="password" name="password"
                       placeholder = "Enter A Complex Password"
                       autocomplete="new-password" required>
            </div>

            <div class="input-container">
                <input  minlength="4"  class="form-control"
                        type="password" name="password-confermation"
                        placeholder = "Conferm Your Password"
                        utocomplete="new-password" required>
            </div>

            <div class="input-container">
                <input class="form-control" type="email"
                       name="email"   placeholder = "Enter Your Valid Email"
                       autocomplete="off" required >
            </div>
                <input class="btn-success btn-block"  type="submit" name="signup"    value="Signup">
        </form>
        <!-- End Form For Signup -->
        <div class="the-errors text-center">
             <?php
                if(!empty($formErrors))
                {
                    foreach($formErrors as $error)
                    {
                        echo '<div class="msg error">' . $error .'</div>' ;
                    }
                }
                if(isset($successMsg))
                {
                    echo '<div class="msg success">'. $successMsg . '</div>';
                }
             ?>
        </div>
    </div>

<?php
include $tpl . "footer.php";
ob_end_flush();
?>

