<?php
use MVC\Support\Session;

//Nhảy đến function incViewFile -file index.php
//Thêm file định dạnh CSS-JS cho header,body,footer
<<<<<<< HEAD
incViewFile("header");//Hiển thị Header
=======
incViewFile('header');//Hiển thị Header

>>>>>>> 908e665a0ca901b8f65af5f2fb70ca81619edf6e
?>
    <!--Body-->
    <div id="container">
        <!--Top-menu-->
        <?php incViewFile("top-menu"); ?>
        <!--Content-->
        <?php
        if (Session::has("login_error")):?>
            <div class="ui error message">
                <p><?php echo Session::get("login_error"); ?></p>
            </div>
        <?php endif;
        ?>
        <form class="ui form" method="POST" action="<?php echo \MVC\Support\Route::get("user/handle-login"); ?>">
            <div class="field">
                <label for="username">Username</label>
                <input id="username" type="text" name="username" placeholder="Username">
            </div>
            <div class="field">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" placeholder="Password">
                <input type="checkbox" onclick="myFunction()">Show Password
            </div>
            <button class="ui button" type="submit">Submit</button>
        </form>
    </div>
<?php
//Include file views/footer->Không có gì
incViewFile("footer");
?>