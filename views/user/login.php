<?php declare(strict_types=1);
use MVC\Support\Session;
use MVC\Support\Route;

//Go to function incViewFile -file index.php
//Add CSS-JS cho header,body,footer
incViewFile("header");//Display Header
?>
    <!--Body-->
    <div id="container">
        <!--Top-menu-->
        <?php incViewFile("top-menu"); ?>
        <!--Content-->
        <?php
        if (Session::has("login_error")) :?>
            <div class="ui error message">
                <p><?php echo Session::get("login_error"); ?></p>
            </div>
        <?php endif;
        ?>
        <form class="ui form" method="POST"
              action="<?php echo Route::get("user/handle-login"); ?>">
            <div class="field">
                <label for="username">Username</label>
                <input id="username" type="text" name="username"
                       placeholder="Username">
            </div>
            <div class="field">
                <label for="password">Password</label>
                <input id="password" type="password" name="password"
                       placeholder="Password">
                <input type="checkbox" onclick="showPassword()">Show Password
            </div>
            <button class="ui button" type="submit">Submit</button>
        </form>
    </div>
<?php
//Include file views/footer
incViewFile("footer");
?>