<?php include 'init.php'; ?>

    <div class="container login-page">
        <h1 class="text-center">
            <span class="selected" id="formButton" date-class="login">Login</span> | <span id="formButton2" date-class="signup">Signup</span>
        </h1>
        <!-- Start Form For Login -->
        <form class="login" action="" method="post" id="form1">
            <input class="form-control" type="text"     name="username" placeholder = "Enter Your Username" autocomplete="off">
            <input class="password form-control" type="password" name="password" placeholder = "Enter Your Password" autocomplete="new-password">
            <i class="show-pass fa fa-eye fa-2x"></i>
            <input class="btn-primary btn-block"  type="submit"   value="Login">
        </form>
        <!-- End Form For Login -->

        <!-- Start Form For Signup -->
        <form class="signup" action="" method="post" id="form2">
            <div class="input-container">
                <input class="form-control" type="text"     name="username"              placeholder = "Enter Username"            autocomplete="off"          required>
            </div>

            <div class="input-container">
                <input class="form-control" type="password" name="password"              placeholder = "Enter A Complex Password"  autocomplete="new-password" required>
            </div>

            <div class="input-container">
                <input class="form-control" type="password" name="password-confermation" placeholder = "Conferm Your Password"     autocomplete="new-password" required>
            </div>

            <div class="input-container">
                <input class="form-control" type="email"    name="email"                 placeholder = "Enter Your Valid Email"    autocomplete="off"          required>
            </div>
                <input class="btn-success btn-block"  type="submit"   value="Signup">
        </form>
        <!-- End Form For Signup -->
    </div>

<?php include $tpl . "footer.php"; ?>

