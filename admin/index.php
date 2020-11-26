<?php
    session_start();
    if(isset($_SESSION['username']))
    {
        header('Location: dashboard.php'); // redirect to dashboard
    }
    include 'init.php';
    include 'includes/languages/en.php';
    include $tpl . "header.php";

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
        $stmt  = $con->prepare("SELECT Username, Password FROM users where Username = ? AND Password = ? AND GroupID = 1");
        $stmt->execute(array($username , $hashedPass));
        /**
         * if count > 0 this mean the db contain record about this username
         */
        $count = $stmt->rowCount(); // exist or not
        if($count > 0)
        {
            /**
             * Register username
             * then redirect to dashboard
             */
            $_SESSION['Username'] = $username;
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
