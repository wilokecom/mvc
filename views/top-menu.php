<?php
use MVC\Support\Route as Route;
use \MVC\Controllers\UserController;

?>
<div class="ui pointing menu">
    <?php
    $aTopMenuItems = getConfig('menu')->getParam('topMenu');

    $route         = isset($_GET['route']) && ! empty($_GET['route']) ? $_GET['route'] : 'home';
    foreach ($aTopMenuItems as $aMenuName) :
        if (isset($aMenuName['isLoggedIn'])){
            if (UserController::isLoggedIn() && !$aMenuName['isLoggedIn']) {
                continue;
            } elseif (
                !UserController::isLoggedIn()
                && $aMenuName['isLoggedIn']
            ) {
                continue;
            }
        }
        $wrapperClass = $route == $aMenuName['route'] ? 'active item' : 'item';
        ?>
        <a href="<?php echo Route::get($aMenuName['route']); ?>" class="<?php echo $wrapperClass; ?>">
            <?php echo $aMenuName['name']; ?>
        </a>
    <?php endforeach; ?>

    <div class="right menu">
        <div class="item">
            <div class="ui transparent icon input">
                <input type="text" placeholder="Search...">
                <i class="search link icon"></i>
            </div>
        </div>
    </div>
</div>
