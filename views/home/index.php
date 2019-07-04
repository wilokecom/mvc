<?php declare(strict_types=1);
    /**
     * Got to incViewFile -file index.php
     * Add CSS-JS for header,body,footer
     */
    incViewFile("header");//Hiển thị Header
?>
<!--Body-->
<div id="container">
    <!--Top-menu-->
    <?php
        incViewFile("top-menu");
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
    incViewFile("footer");
?>

