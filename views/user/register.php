<?php
use \MVC\Support\Route;
use \MVC\Support\Session;

incViewFile('header');
?>
<div id="container">
    <?php incViewFile('top-menu'); ?>

    <?php
    $hasError = Session::has('register_error');
    if ($hasError) {
        $formClass = 'ui form error';
    } else {
        $formClass = 'ui form';
    }
    ?>
    <form class="<?php echo $formClass; ?>" method="POST" action="<?php echo Route::get('user/handle-register'); ?>">
        <?php if ($hasError) : ?>
        <div class="ui error message">
            <p><?php echo Session::get('register_error'); ?></p>
        </div>
        <?php endif; ?>
        <div class="field">
            <label for="username">Username</label>
            <input id="username" type="text" name="username" placeholder="Username">
        </div>
        <div class="field">
            <label for="password">Password</label>
            <input id="password" type="text" name="password" placeholder="Password">
        </div>
        <div class="field">
            <label for="email">Email</label>
            <input id="email" type="text" name="email" placeholder="Email">
        </div>
        <div class="field">
            <div class="ui checkbox">
                <input id="agree-term" name="agree_term" type="checkbox" class="hidden">
                <label for="agree-term">I agree to the Terms and Conditions</label>
            </div>
        </div>
        <button class="ui button" type="submit">Submit</button>
    </form>
</div>
<?php
incViewFile('footer');
?>
