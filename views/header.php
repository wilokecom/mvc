<!DOCTYPE html>
<html lang="en-US">
<head>
    <title>MVC</title>
    <script>
        "use strict"
        let HomeURL = "<?php echo MVC_HOME_URL;?>"
    </script>
    <?php
    //Add file CSS
    //mvcHead là key của mảng chứa đường dẫn đến file CSS trong file app/Support/HandleAction.php
    doAction("mvcHead"); //Nhảy đến hàm doAction-file index.php
    ?>
</head>
<body>


