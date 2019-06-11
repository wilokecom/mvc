<?php
use MVC\Support\Session;
incViewFile('header');
?>
    <div id="container">
        <?php incViewFile('top-menu'); ?>
        <?php
        if (Session::has('login_error')):?>
            <div class="ui error message">
                <p><?php echo Session::get('login_error'); ?></p>
            </div>
        <?php endif;
        ?>
        <form class="ui form" method="POST" action="<?php echo \MVC\Support\Route::get('user/handle-login'); ?>">
            <div class="field">
                <label for="username">Username</label>
                <input id="username" type="text" name="username" placeholder="Username">
            </div>
            <div class="field">
                <label>Password</label>
                <input type="text" name="password" placeholder="Password">
            </div>
            <div class="field">
                <div class="ui checkbox">
                    <input id="agree-to-term" type="checkbox" tabindex="0" class="hidden">
                    <label for="agree-to-term">I agree to the Terms and Conditions</label>
                </div>
            </div>
            <button class="ui button" type="submit">Submit</button>
        </form>
    </div>
    <!--Footer-->
<?php
incViewFile('footer');