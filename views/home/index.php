<?php
//Nhảy đến function incViewFile -file index.php
//Thêm file định dạnh CSS-JS cho header,body,footer
    incViewFile('header');//Hiển thị Header
?>
<!--Body-->
<div id="container">
    <!--Top-menu-->
    <?php
        incViewFile('top-menu');
    ?>
    <!--Content-->
    <div class="ui message green">
        <div class="sixteen wide column">Hello! Thank for visited MVC</div>
        <h1>Đây là trang HOME</h1>
    </div>
</div>
<!--Footer-->
<?php
    //Include file views/footer->Không có gì
    incViewFile('footer');
?>

