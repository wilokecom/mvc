<?php
//Nhảy đến function incViewFile -file index.php
//Thêm file định dạnh CSS-JS cho header, footer
    incViewFile('header');
?>
<!--Content-->
<div id="container">
    <?php
        //menu-bar
        incViewFile('top-menu');
    ?>
    <div class="ui message green">
        <div class="sixteen wide column">Hello! Thank for visitit MVC</div>
        <h1>Đây là trang HOME</h1>
    </div>


</div>
<!--Footer-->
<?php
    incViewFile('footer');
?>
