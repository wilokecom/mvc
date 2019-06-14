<?php
//Nhảy đến function incViewFile -file index.php
//Thêm file định dạnh CSS-JS cho header,body,footer
incViewFile('header'); //Header
?>
<!--Body-->
<div id="container">
    <!--Top-menu-->
    <?php
    incViewFile('top-menu');
    ?>
    <!--Content-->
    <div class="ui success message">
        <div class="header">Hello <span style="color:red;"><?php echo $username; ?></span>!<!--Hello username-->
            <p>Đây là trang Dashboard.</p>
        </div>
    </div>
</div>
<?php
//Include file views/footer->Không có gì
incViewFile('footer');
?>
