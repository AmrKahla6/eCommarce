<?php
    session_start();

    $noNavbar  = "";
    $pageTitle = "Login";

    if(isset($_SESSION['username']))
    {
        header('Location: dashboard.php'); // redirect to dashboard
    }
    include 'init.php';


    /**
     * Check if user comming from http request
     */
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $username   = $_POST['user'];
        $password   = $_POST['pass'];
        $hashedPass = sha1($password);

        /**
         * Check if user exist in db
         */
        $stmt  = $con->prepare("SELECT
                                    UserID , Username , Password
                                FROM
                                    users
                                where
                                    Username = ?
                                AND
                                    Password = ?
                                AND
                                   GroupID = 1
                                LIMIT 1");
        $stmt->execute(array($username , $hashedPass));
        /**
         * if count > 0 this mean the db contain record about this username
         */
        $count = $stmt->rowCount(); // exist or not
        $row   = $stmt->fetch();
        if($count > 0)
        {
            /**
             * Register username
             * Register user id
             * then redirect to dashboard
             */
            $_SESSION['Username'] = $username;
            $_SESSION['ID']       = $row['UserID'];
            header('Location: dashboard.php');
            exit();
        }
    }
?>
<!-- login form -->

  <form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
      <h3 class="text-center">Admin Login</h3>
      <input class="form-control input-lg" type="text" name="user" placeholder="Username" autocomplete="off"/>
      <input class="form-control input-lg" type="password" name="pass" placeholder="Password" autocomplete="new-password"/>
      <input class="btn btn-lg btn-primary btn-block" type="submit" value="Login">
  </form>
<?php include $tpl . "footer.php"; ?>
