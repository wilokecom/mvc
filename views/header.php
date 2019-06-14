<!DOCTYPE html>
<html lang="en-US">
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<head>
    <title>MVC</title>
    <meta charset="UTF-8">
    <?php
    //Add file CSS
    //mvcHead là key của mảng chứa đường dẫn đến file CSS trong file app/Support/HandleAction.php
    doAction('mvcHead'); //Nhảy đến hàm doAction-file index.php
    ?>
</head>
<body>
<?php
//Add file JS
//mvcFooter là key của mảng chứa đường dẫn đến file JS trong file app/Support/HandleAction.php
doAction('mvcFooter'); //Nhảy đến hàm doAction-file index.php
?>
</body>