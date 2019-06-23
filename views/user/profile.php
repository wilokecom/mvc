<?php

//use MVC\Support\Session;
incViewFile('header');
?>
    <div id="container">
        <?php incViewFile('top-menu'); ?>

        <form class="ui form" method="POST" action="<?php echo \MVC\Support\Route::get('user/edit-profile'); ?>">
            <div class="field">
                <label>Ảnh đại diện : </label>
                <img src="<?php if (isset($meta_value)) {
                    echo MVC_ASSETS_URL . 'Images' . '/' . $meta_value;
                } ?>" width="150" height="150">
                <!--                <input type="file" name="file-upload" >-->
            </div>

            <div class="field">
                <label style="color: Green;">Họ Tên : </label>
                <span style="font-weight: bold; font-size: 20px; color: red;"><?php if (isset($meta_key)) {
                        echo $meta_key;
                    } ?></span>
                <!--                <input type="text" name="fullname" placeholder="full-name" value="">-->
            </div>

            <div class="field">
                <label style="color: Green;">Username : </label>
                <span style="font-weight: bold; font-size: 20px; color: red;"><?php echo $username; ?></span>
            </div>

            <div class="field">
                <label style="color: Green;">Email : </label>
                <span style="font-weight: bold; font-size: 20px; color: red;"><?php echo $email; ?></span>
            </div>
            <button class="ui button" type="submit">Edit</button>
        </form>
    </div>
    <!--Footer-->
    
<?php

incViewFile('footer');

//            <div class="field">
//                <div class="ui checkbox">
//                    <input id="agree-to-term" type="checkbox" tabindex="0" class="hidden">
//                    <label for="agree-to-term">I agree to the Terms and Conditions</label>
//                </div>
//            </div>