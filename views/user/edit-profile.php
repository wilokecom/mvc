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
<!--            <div class="field">-->
<!--                <label>Upload</label>-->
<!--                -->
<!--            </div>-->
            <div class="field">
                <label>Ảnh đại diện : </label>
                <img src= "<?php if(isset($meta_value)) echo MVC_ASSETS_URL.'Images'.'/'.$meta_value;?>" width="150" height="150">
                <input type="file" name="file-upload">
                <!--                <input type="file" name="file-upload" >-->
            </div>
<!--            <div class="ui action input">-->
<!--                <input id="featured-image" type="file" placeholder="Featured Image" name="file-upload">-->
<!--                <label for="featured-image" class="ui button">Upload</label>-->
<!--            </div>-->

            <div class="field">
                <label>Họ Tên</label>
                <input type="text" name="fullname" placeholder="full-name" value="<?php if(isset($meta_key)){echo $meta_key;}?>">
            </div>

            <div class="field">
                <label>UserName</label>
                <input type="text" name="username" placeholder="full-name" value="<?php if(isset($username)){echo $username;}?>">
            </div>

            <div class="field">
                <label>PassWord</label>
                <input type="text" name="password" placeholder="full-name" value="<?php if(isset($password)){echo $password;}?>">
            </div>

            <div class="field">
                <label>Email</label>
                <input type="text" name="email" placeholder="full-name" value="<?php if(isset($email)){echo $email;}?>">
            </div>

            <button class="ui button" type="Save">Save</button>
        </form>
    </div>
<?php

incViewFile('footer');