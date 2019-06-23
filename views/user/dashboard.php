<?php
incViewFile('header'); //Header
?>
<div id="container">
    <?php
    incViewFile('top-menu');//Top-menu
    ?>
    <div class="ui success message">
        <div class="header">Hello <span style="color:red;"> <?php echo $username; ?> </span>!<!--Hello username-->
            <?php echo $ID;?>
            <?php echo $email;?>
        </div>
    </div>

</div>
<?php
incViewFile('footer'); //Footer
?>
