<?php incViewFile('header'); ?>
    <div id="container">
        <?php incViewFile('top-menu'); ?>
        <div class="ui message green">
            <div class="sixteen wide column">Log In Please !</div>
        </div>

        <form class="ui form" method="POST" action="<?php echo MVC_HOME_URL . 'user/handle-login'; ?>">
            <div class="field">
                <label>UserName</label>
                <input type="text" name="username" placeholder="First Name">
            </div>

            <div class="field">
                <label>PassWords</label>
                <input type="password" name="password" placeholder="Last Name">
            </div>

            <div class="field">
                <div class="ui checkbox">
                    <input type="checkbox" tabindex="0" class="hidden">
                    <label>I agree to the Terms and Conditions</label>
                </div>
            </div>
            <button class="ui button" type="submit">Submit</button>
        </form>

    </div>
<?php incViewFile('footer'); ?>