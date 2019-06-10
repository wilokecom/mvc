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
                <label for="password">Password</label>
                <input id="password" type="text" name="password" placeholder="Password">
            </div>
            <button class="ui button" type="submit">Submit</button>
        </form>
    </div>
    <!--Footer-->
<?php
incViewFile('footer');