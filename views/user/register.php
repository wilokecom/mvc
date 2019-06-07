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
            <label>Username</label>
            <input type="text" name="username" placeholder="Username">
        </div>
        <div class="field">
            <label>Password</label>
            <input type="password" name="password" placeholder="Password">
        </div>
        <div class="field">
            <label>Email</label>
            <input type="email" name="email" placeholder="Email">
        </div>
        <button class="ui button" type="submit">Submit</button>
    </form>
</div>
<?php incViewFile('footer'); ?>
