<?php

use \MVC\Support\Route;
use \MVC\Support\Session;

//Nhảy đến function incViewFile -file index.php
//Thêm file định dạnh CSS-JS cho header,body,footer
incViewFile('header');//Hiển thị Header
?>
<!--Body-->
<div id="container">
    <!--Top-menu-->
    <?php incViewFile('top-menu'); ?>
    <!--Content-->
    <!--Error-->
    <?php
    $hasError = Session::has('register_error');//Get Error
    if ($hasError) {//Nếu có lỗi
        $formClass = 'ui form error';
    } else {//Nếu không có lỗi
        $formClass = 'ui form';
    }
    ?>
    <form class="<?php echo $formClass; ?>" method="POST" action="<?php echo Route::get('user/handle-register'); ?>">
       <!--Display Error-->
        <?php if ($hasError) : ?>
            <div class="ui error message">
                <p><?php echo Session::get('register_error'); ?></p>
            </div>
        <?php endif; ?>
        <!--Username-->
        <div class="field">
            <label for="username">Username</label>
            <input id="username" type="text" name="username" placeholder="Username">
        </div>
        <!--Password-->
        <div class="field">
            <label for="password">Password</label>
            <input id="password" type="text" name="password" placeholder="Password">
        </div>
        <!--Email-->
        <div class="field">
            <label for="email">Email</label>
            <input id="email" type="text" name="email" placeholder="Email">
        </div>
        <!--Checkbox-->
        <div class="field">
            <div class="ui checkbox">
                <input id="agree-term" name="agree_term" type="checkbox" class="hidden">
                <label for="agree-term">I agree to the Terms and Conditions</label>
            </div>
        </div>
        <!--Submit-->
        <button class="ui button" type="submit">Submit</button>
    </form>
</div>
<?php
incViewFile('footer');
?>
