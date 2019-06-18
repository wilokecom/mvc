<?php
/**
 * Created by PhpStorm.
 * User: doduc
 * Date: 05/06/2019
 * Time: 3:12 CH
 */
 incViewFile('header'); ?>
    <div id="container">
        <?php incViewFile('top-menu'); ?>

        <div class="ui message green">
            <div class="sixteen wide column">Let register !!!!</div>
        </div>

        <form class="ui form" method="POST" action="<?php echo MVC_HOME_URL . 'user/handle-register'; ?>">
<!--            Tên đăng nhập          -->
            <div class="field">
                <label>UserName</label>
                <input type="text" name="username" placeholder="First Name">
            </div>

<!--            Mật Khẩu               -->
            <div class="field">
                <label>PassWords</label>
                <input type="password" name="password" placeholder="Last Name">
            </div>

<!--            Email                  -->
            <div class="field">
                <label>Email</label>
                <input type="text" name="email" placeholder="Last Name">
            </div>

<!--            Thông tin khác         -->
            <div class="field">
                <label>Thông tin khác</label>
                <input type="text" name="khac" placeholder="thông tin khác">
            </div>
<!--        Check box                  -->
            <div class="field">
                <div class="ui checkbox">
                    <input type="checkbox" tabindex="0" class="hidden">
                    <label>I agree to the Terms and Conditions</label>
                </div>
            </div>

<!--            Đăng kí                -->
            <button class="ui button" type="submit">Register</button>
        </form>

    </div>
<?php incViewFile('footer'); ?>