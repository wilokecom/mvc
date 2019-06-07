<div class="ui pointing menu">
    <?php
    $aMenus = getConfig('menu')->getAll();
//    $aMenus = getConfig('menu')->getAll();
//    getParam('home', true)->getParam('SubMenu');var_dump($aMenus);die;     lấy phần tử trong mảng
    $route = isset($_GET['route']) ? $_GET['route'] : 'index';
    foreach ($aMenus as $keyMenu => $aMenuName)
    {
     ?>
     <a class="<?php echo $aMenuName['route'] == $route ? 'active item ' : 'item'; ?>"
        href="<?php echo MVC_HOME_URL.$aMenuName['route']; ?>">
         <?php echo $aMenuName['name']; ?></a>

     <?php
    }
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
