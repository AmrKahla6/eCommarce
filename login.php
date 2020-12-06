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
                                        Username , Password
                                    FROM
                                        users
                                    where
                                        Username = ?
                                    AND
                                        Password = ?");
            $stmt->execute(array($username , $hashedPass));

            //if count > 0 this mean the db contain record about this username
            $count = $stmt->rowCount(); // exist or not
            if($count > 0)
            {
                $_SESSION['user'] = $username;
                // print_r($_SESSION['user']);
                header('Location: index.php');
                exit();
            }
        }
        else
        {
            $formErrors = array();

            //Username Filter & Errors
            if(isset($_POST['username']))
            {
                $filterUser = filter_var($_POST['username'] , FILTER_SANITIZE_STRING);
                if(strlen($filterUser) < 4)
                {
                    $formErrors[] = 'Username Must Be Larger Than 4 Characters';
                }
            }

            //Password Filter & Errors
            if(isset($_POST['password']) && isset($_POST['password-confermation']))
            {
                if(empty($_POST['password']))
                {
                    $formErrors[] = 'Password Can\'t Be Null';
                }

                $pass1 =  sha1($_POST['password']);
                $pass2 =  sha1($_POST['password-confermation']);

                if($pass1 !== $pass2)
                {
                    $formErrors[] = 'Password Is\'t Match';
                }
            }


              //Email Filter & Errors
              if(isset($_POST['email']))
              {
                  $filterEmail = filter_var($_POST['email'] , FILTER_SANITIZE_EMAIL);
                  if(filter_var($filterEmail , FILTER_VALIDATE_EMAIL) != true)
                  {
                      $formErrors[] = 'This Email Is Not Valid';
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
                        echo $error . '<br>';
                    }
                }
             ?>
        </div>
    </div>

<?php
include $tpl . "footer.php";
ob_end_flush();
?>

