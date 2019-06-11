<?php

use MVC\Support\Route as Route;
use \MVC\Controllers\UserController;

?>
<div class="ui pointing menu">
    <?php
    //Trả về mảng
    $aTopMenuItems = getConfig('menu')->getParam('topMenu');
    $route = isset($_GET['route']) && !empty($_GET['route']) ? $_GET['route'] : 'home';//user/dashboard
    //$aMenuName=arr(name=>'Post', route=>'post')
    foreach ($aTopMenuItems as $aMenuName) :
        if (isset($aMenuName['isLoggedIn'])) {
            if ((UserController::isLoggedIn() && !$aMenuName['isLoggedIn']) || (!UserController::isLoggedIn() && $aMenuName['isLoggedIn'])) {
                continue;
            }
        }
        $wrapperClass = $route == $aMenuName['route'] ? 'active item' : 'item';//item
        ?>
        <a href="<?php echo Route::get($aMenuName['route']); ?>" class="<?php echo $wrapperClass; ?>"><!--mvc/post-->
            <?php
            echo $aMenuName['name']; //Post
            ?>
        </a>
    <?php
    endforeach;
    ?>
    <div class="right menu">
        <div class="item">
            <div class="ui transparent icon input">
                <input type="text" placeholder="Search...">
                <i class="search link icon"></i>
            </div>
        </div>
    </div>
</div>
