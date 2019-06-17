<!DOCTYPE html>
<html lang="en-US">
<head>
    <title>MVC</title>
    <!--Add file script-->
    <script type="javascript" src="<?php echo MVC_ASSETS_DIR ?>js/01.js">" </script>
    <?php
    //Add file CSS
    //mvcHead là key của mảng chứa đường dẫn đến file CSS trong file app/Support/HandleAction.php
    doAction("mvcHead"); //Nhảy đến hàm doAction-file index.php
    ?>
</head>
<body>
<?php
//Add file JS
//mvcFooter là key của mảng chứa đường dẫn đến file JS trong file app/Support/HandleAction.php
doAction("mvcFooter"); //Nhảy đến hàm doAction-file index.php
?>
</body>

