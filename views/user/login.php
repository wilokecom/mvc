<?php incViewFile('header'); ?>
<div id="container">
    <?php incViewFile('top-menu'); ?>

    <form class="ui form" method="POST" action="<?php echo \MVC\Support\Route::get('user/handle-login'); ?>">
        <div class="field">
            <label>Username</label>
            <input type="text" name="username" placeholder="Username">
        </div>
        <div class="field">
            <label>Password</label>
            <input type="text" name="password" placeholder="Password">
        </div>
        <button class="ui button" type="submit">Submit</button>
    </form>
</div>
<?php incViewFile('footer'); ?>
