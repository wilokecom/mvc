<?php
/**
 * Created by PhpStorm.
 * User: doduc
 * Date: 11/06/2019
 * Time: 10:40 SA
 */

use MVC\Support\Session;

incViewFile('header');
$aUserInfo = $aData[0];
$aName = $aData[1];
?>
    <div id="container">
        <?php
        incViewFile('top-menu');
        ?>
        <form class="ui form" action="<?php echo \MVC\Support\Route::get('user/handleEditProfile')?>" enctype="multipart/form-data" method="post">

            <div class="field" >
                <label>Ảnh đại diện : </label>
                <img id="img" src= "<?php if(isset($aName['meta_value'])) echo MVC_ASSETS_URL.'Images'.'/'.$aName['meta_value'];?>" width="150" height="150">
                <input type="file" name="file-upload" multiple="true">
            </div>
            <div class="field">
                <label>Trường Meta_Key</label>
                <input type="text" name="fullname" placeholder="full-name" value="<?php if(isset($aName['meta_key'])){echo $aName['meta_key'];}?>">
            </div>
            <div class="field">
                <label>UserName</label>
                <input type="text" name="username" placeholder="username" value="<?php if(isset($aUserInfo['username'])){echo $aUserInfo['username'];}?>">
            </div>
            <div class="field">
                <label>PassWord</label>
                <input type="text" name="password" placeholder="password" value="<?php if(isset($aUserInfo['password'])){echo $aUserInfo['password'];}?>">
            </div>
            <div class="field">
                <label>Email</label>
                <input type="text" name="email" placeholder="email" value="<?php if(isset($aUserInfo['email'])){echo $aUserInfo['email'];}?>">
            </div>
            <button class="ui button" type="Save">Save</button>
        </form>
    </div>
<?php

incViewFile('footer');