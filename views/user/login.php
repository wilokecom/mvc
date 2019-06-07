<?php
//Nhảy đến function incViewFile -file index.php
//Thêm file định dạnh CSS-JS cho header, footer
incViewFile('header');
?>
<!--Content-->
<div id="container">
    <?php
        //menu-bar
        incViewFile('top-menu');
    ?>
    <div class="ui message green">
        <div class="sixteen wide column">Hello! Thank for visitit MVC</div>
    </div>

    <form class="ui form" method="post" action="http://localhost/mvc/user/login" name="form-login">
        <div class="field">
            <label>{{UserName</label>
            <input type="text" name="username" placeholder="UserName">
        </div>
        <div class="field">
            <label>Password</label>
            <input type="text" name="password" placeholder="Password">
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
<!--Footer-->
<?php
incViewFile('footer');
?>
