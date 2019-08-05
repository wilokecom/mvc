<!DOCTYPE html>
<html lang="en-US">
<head>
    <title>MVC</title>
    <script>
        "use strict";
        let HomeURL = "<?php echo MVC_HOME_URL;?>";
    </script>
    <?php
    //Add file CSS
    //mvcFooter is key of array contain link file CSS in file app/Support/HandleAction.php
    doAction("mvcHead"); //Go to doAction-file index.php
    ?>
</head>
<body>



