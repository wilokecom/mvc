<?php
use MVC\Support\Route as Route;
use \MVC\Controllers\UserController;
?>
<div class="ui pointing menu">
    <?php
    //Trả về mảng của phần tử topMenu trong file config có đường dẫn app/configs/menu
    $aTopMenuItems = getConfig("menu")->getParam("topMenu");
    //Lấy đường dẫn url
    $route = isset($_GET["route"]) && !empty($_GET["route"]) ? $_GET["route"]
        : "home";//user/dashboard
    //Duyệt các phần tử mảng $aTopMenuItems
    foreach ($aTopMenuItems as $aMenuName) ://Dấu ":" dùng với endforeach
        if (isset($aMenuName["isLoggedIn"])) {//Nếu tồn tại phần tử "isLoggedIn" trong mảng $aMenuName
            //Nếu đã login thì chỉ hiển thị Logout, Post
            //Nêu chưa login thì hiển thị Home, Login, Register
            if ((UserController::isLoggedIn() && !$aMenuName["isLoggedIn"])
                || (!UserController::isLoggedIn() && $aMenuName["isLoggedIn"])
            ) {
                continue;
            }
        }
        //$wrapperClass dùng để hiển thị class
        //Nếu $aMenuName["route"]= url hiện tại thì class là "active item"
        //Nếu $aMenuName["route"]!=url hiện tại thì class là "item"
        $wrapperClass = $route == $aMenuName["route"] ? "active item"
            : "item";//item
        ?>
        <!--Hiển thị menu đường dẫn-->
        <a href="<?php echo Route::get($aMenuName["route"]); ?>"
           class="<?php echo $wrapperClass; ?>"><!--mvc/post/index-->
            <?php
            echo $aMenuName["name"]; //Post
            ?>
        </a>
    <?php
    endforeach;
    ?>
    <div class="right menu">
        <form class="ui form" method="get"  action="<?php echo
        \MVC\Support\Route::get
        ('post/handleSearch'); ?>">
        <div class="item">
<!--            <div class="ui transparent icon input">-->
                <input type="text" name="search"
                       placeholder="Search...">
                <button  type="submit" value="Search"><i class="search link
                icon"></i></button>
<!--            </div>-->
        </div>
        </form>
    </div>
</div>
