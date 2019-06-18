<?php
/**
 * Created by PhpStorm.
 * User: doduc
 * Date: 11/06/2019
 * Time: 10:40 SA
 */

use MVC\Support\Session;

incViewFile('header');
?>
    <div id="container">
        <?php
        incViewFile('top-menu');//Top-menu
        ?>
        <form class="ui form" action="<?php echo \MVC\Support\Route::get('user/upload')?>" enctype="multipart/form-data" method="post">
            <div class="field">
                <label>Upload</label>
                <input type="file" name="file-upload">
            </div>
<!--            <div class="ui action input">-->
<!--                <input id="featured-image" type="file" placeholder="Featured Image" name="file-upload">-->
<!--                <label for="featured-image" class="ui button">Upload</label>-->
<!--            </div>-->

            <div class="field">
                <label>Họ Tên</label>
                <input type="text" name="fullname" placeholder="full-name">
            </div>
            <div class="field">
                <div class="ui checkbox">
                    <input id="agree-to-term" type="checkbox" tabindex="0" class="hidden">
                    <label for="agree-to-term" >I agree to the Terms and Conditions</label>
                </div>
            </div>
            <button class="ui button" type="submit">Submit</button>
        </form>
    </div>
<?php

incViewFile('footer');