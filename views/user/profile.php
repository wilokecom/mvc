<?php
use MVC\Support\Session;
incViewFile('header');
if (isset($aData))
{
    $aUserInfo = $aData[0];
    $aName = $aData[1];
}
?>
    <div id="container">
        <?php incViewFile('top-menu'); ?>
        <form class="ui form" method="POST" action="<?php echo \MVC\Support\Route::get('user/edit-profile'); ?>">
            <div class="field">
                <label>Ảnh đại diện : </label>
                <img src="<?php if (isset($aName['meta_value'])) {
                    echo MVC_ASSETS_URL . 'Images' . '/' . $aName['meta_value'];
                } ?>" width="150" height="150">
            </div>

            <div class="field">
                <label style="color: Green;">Meta_Key : </label>
                <span style="font-weight: bold; font-size: 20px; color: red;"><?php if (isset($aName['meta_key'])) {
                        echo $aName['meta_key'];
                    } ?></span>
                <!--                <input type="text" name="fullname" placeholder="full-name" value="">-->
            </div>
            <div class="field">
                <label style="color: Green;">Username : </label>
                <span style="font-weight: bold; font-size: 20px; color: red;
"><?php echo $aUserInfo['username']; ?></span>
            </div>

            <div class="field">
                <label style="color: Green;">Email :</label>
                <span style="font-weight: bold; font-size: 20px; color: red;
"><?php echo $aUserInfo['email']; ?></span>
            </div>
            <button class="ui button" type="submit">Edit</button>
        </form>
    </div>
    <!--Footer-->

<?php
incViewFile('footer');