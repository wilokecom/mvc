<?php
use MVC\Support\Route as Route;
use \MVC\Controllers\UserController;
?>
<div class="ui pointing menu">
    <?php
    //Top menu app/configs/menu
    $aTopMenuItems = getConfig("menu")->getParam("topMenu");
    //Get url:user/dashboard
    $route = isset($_GET["route"]) && !empty($_GET["route"]) ? $_GET["route"] : "home";
    foreach ($aTopMenuItems as $aMenuName) ://Signal ":" use with endforeach
        if (isset($aMenuName["isLoggedIn"])) {//If exist "isLoggedIn"in array $aMenuName
            //If logined, display Logout, Post
            //If not logined Home, Login, Register
            if ((UserController::isLoggedIn() && !$aMenuName["isLoggedIn"]) || (!UserController::isLoggedIn() && $aMenuName["isLoggedIn"])) {
                continue;
            }
        }
        //$wrapperClass used for display class
        //If $aMenuName["route"]= url, class is "active item"
        //If $aMenuName["route"]!=url, class is "item"
        $wrapperClass = $route == $aMenuName["route"] ? "active item" : "item";//item
        ?>
        <!--Display menu link-->
        <a href="<?php echo Route::get($aMenuName["route"]); ?>" class="<?php echo $wrapperClass; ?>"><!--mvc/post/index-->
            <?php
            echo $aMenuName["name"];
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
